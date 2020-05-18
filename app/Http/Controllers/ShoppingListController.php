<?php

namespace App\Http\Controllers;

use App\ListComment;
use App\ListItem;
use App\ShoppingList;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Comment;

class ShoppingListController extends Controller
{
    public function index() {
        $lists = ShoppingList::with(['list_items', 'comments', 'users'])->get();
        return $lists;
    }

    public function showByUserId ($userId) {
        $lists = ShoppingList::
            where('creator_id', $userId)
            ->with(['list_items', 'comments', 'users'])
            ->get();
        return $lists;
    }

    # show detail-page of List
    public function showById($listId) {
        $lists = ShoppingList::where('id', $listId)
            ->with(['list_items', 'comments', 'users'])
            ->get();
        return $lists;
    }

    # shows all open lists an volunteer lists
    public function showListsVolunteer($volunteerId) {
        $lists = ShoppingList::where('status', '=', 'open')
            ->OrWhere('volunteer_id', '=', $volunteerId)
            ->get();
        return $lists;
    }


    # help-seeker lists
    public function showHelpSeekerLists($userId) {
        $lists = ShoppingList::where('creator_id', $userId)
            ->get();
        return $lists;
    }
    public function showHelpSeekerListsOpen($userId) {
        $lists = ShoppingList::where('creator_id', $userId)
            ->where('status', '=', 'open')
            ->get();
        return $lists;
    }
    public function showHelpSeekerListsClose($userId) {
        $lists = ShoppingList::where('creator_id', $userId)
            ->where('status', '=', 'close')
            ->get();
        return $lists;
    }


    # volunteer lists
    public function showVolunteerLists($userId) {
        $lists = ShoppingList::where('volunteer_id', $userId)
            ->get();
        return $lists;
    }
    public function showVolunteerListsOpen($userId) {
        $lists = ShoppingList::where('volunteer_id', $userId)
            ->where('status', '=', 'open')
            ->get();
        return $lists;
    }
    public function showVolunteerListsClose($userId) {
        $lists = ShoppingList::where('volunteer_id', $userId)
            ->where('status', '=', 'close')
            ->get();
        return $lists;
    }



    # save shoppingList
    public function save(Request $request) {
        $request = $this->parseRequest($request);

        DB::beginTransaction();
        try {
            $shoppingList = ShoppingList::create($request->all());

            # set id to shopping_list_user
            if(isset($request['creator_id']) && isset($request['volunteer_id'])) {
                $shoppingList->users()->sync([$request['creator_id'], $request['volunteer_id']]);
            } else if(isset($request['creator_id'])) {
                $shoppingList->users()->sync([$request['creator_id']]);
            }

            # add items
            if(isset($request['list_items']) && is_array($request['list_items'])) {
                foreach ($request['list_items'] as $listItem) {
                    if(
                        ($listItem['title'] == "" || $listItem['title'] == null)
                        && ($listItem['amount'] == "" || $listItem['amount'] == null)
                        && ($listItem['extra_info'] == "" || $listItem['extra_info'] == null)
                        && ($listItem['max_price'] == "" || $listItem['max_price'] == null)
                    ) {
                        continue;
                    } else {
                        $item = ListItem::create([
                            'title' => $listItem['title'],
                            'amount' => $listItem['amount'],
                            'extra_info' => $listItem['extra_info'],
                            'max_price' => $listItem['max_price']
                        ]);
                    }
                    $shoppingList->list_items()->save($item);
                }
            }

            # add comments
            if(isset($request['comments']) && is_array($request['comments'])) {
                foreach ($request['comments'] as $comment) {
                    $comment = ListComment::create([
                        'comment' => $comment['comment'],
                        'user_id' => $comment['user_id']
                    ]);
                    $shoppingList->comments()->save($comment);
                }
            }

            DB::commit();
            return response()->json($shoppingList, 201);
        }
        catch(\Exeption $e) {
            DB::rollBack();
            return response()->json("saving shoppingList failes: " . $e->getMessage(), 420);
        }
    }

    # delete shoppingList
    public function delete(int $id) {
        $shoppingList = ShoppingList::where('id', $id);

        if ($shoppingList != null) {
            $shoppingList->delete();
        } else
            throw new \Exception("shoppingList couldn't be deleted - it does not exist");

        return response()->json('shoppingList (' . $id . ') successfully deleted', 200);

    }

    # update shoppingList
    public function update(Request $request, int $id) {

        DB::beginTransaction();
        try {
            $shoppingList = ShoppingList::with(['list_items', 'comments', 'users'])
                ->where('id', $id)->first();

            $request = $this->parseRequest($request);

            if ($shoppingList != null && $shoppingList['status'] != 'closed') {

                $shoppingList->update($request->all());

                # add items
                if (isset($request['list_items']) && is_array($request['list_items'])) {
                    $shoppingList->list_items()->delete();

                    foreach ($request['list_items'] as $listItem) {
                        if(
                            ($listItem['title'] == "" || $listItem['title'] == null)
                            && ($listItem['amount'] == "" || $listItem['amount'] == null)
                            && ($listItem['extra_info'] == "" || $listItem['extra_info'] == null)
                            && ($listItem['max_price'] == "" || $listItem['max_price'] == null)
                        ) {
                            continue;
                        } else {
                            $item = ListItem::create([
                                'title' => $listItem['title'],
                                'amount' => $listItem['amount'],
                                'extra_info' => $listItem['extra_info'],
                                'max_price' => $listItem['max_price']
                            ]);
                        }
                        $shoppingList->list_items()->save($item);
                    }
                }

                # add comments
                if(isset($request['comments']) && is_array($request['comments'])) {
                    $shoppingList->comments()->delete();

                    foreach ($request['comments'] as $comment) {
                        $comment = ListComment::create([
                            'comment' => $comment['comment'],
                            'user_id' => $comment['user_id']
                        ]);
                        $shoppingList->comments()->save($comment);
                    }
                }
            }
            DB::commit();

            $shoppingList1 = ShoppingList::with(['list_items', 'comments', 'users'])
                ->where('id', $id);

            return response()->json($shoppingList1, 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json("updating shoppingList failed: " . $e->getMessage(), 420);
        }
    }


    public function getUserById ($userId) {
        $user = User::where('id', $userId)
            ->with(['address'])
            ->get();
        return $user;
    }


    private function parseRequest (Request $request) {
        $date = new \DateTime($request->due_date);
        $request['due_date'] = $date;

        return $request;
    }
}
