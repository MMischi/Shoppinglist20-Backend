<?php

use Illuminate\Database\Seeder;

class ShoppingListsTableSeeder extends Seeder
{

    public function run()
    {
        $shoppingList1 = new App\ShoppingList;
        $shoppingList1->title = 'Liste 1';
        $shoppingList1->due_date = new DateTime();
        $shoppingList1->price = 20;
        $shoppingList1->status = 'open';

        $user = App\User::all();
        # add creator
        $shoppingList1->creator()->associate($user[1]);

        # add volunteer
        $shoppingList1->volunteer()->associate($user[0]);

        $shoppingList1->save();

        # fill shopping_list_user table (n:m relationship)
        /*
        $users = new App\User;
        $usersId = $users::all()->pluck('id');
        $shoppingList1->users()->sync([$usersId[0], $usersId[1]]);

        $shoppingList1->save();
        */

        # ----

        $shoppingList2 = new App\ShoppingList;
        $shoppingList2->title = 'Liste 2';
        $shoppingList2->due_date = new DateTime();
        $shoppingList2->price = 20;
        $shoppingList2->status = 'close';

        $user = App\User::all();
        # add creator
        $shoppingList2->creator()->associate($user[1]);

        # add volunteer
        $shoppingList2->volunteer()->associate($user[2]);

        $shoppingList2->save();

        # fill shopping_list_user table (n:m relationship)
        /*
        $users = new App\User;
        $usersId = $users::all()->pluck('id');
        $shoppingList2->users()->sync([$usersId[2], $usersId[1]]);
        $shoppingList2->save();
        */

        # --------------------------------------------------------------------------------------------------------------
        # LIST ITEMSs

        $item1 = new App\ListItem;
        $item1->title = 'Apfel';
        $item1->amount = 3;
        $item1->max_price = 4.50;

        $item2 = new App\ListItem;
        $item2->title = 'Semmeln';
        $item2->amount = 1;
        $item2->max_price = 0.50;

        $item3 = new App\ListItem;
        $item3->title = 'Wasser';
        $item3->amount = 1;
        $item3->extra_info = 'Ein sechser Tragerl MixIt';
        $item3->max_price = 3.50;

        $shoppingList1->listItems()->saveMany([
            $item1, $item2, $item3
        ]);

        $shoppingList2->listItems()->saveMany([
            $item1, $item2
        ]);

        # --------------------------------------------------------------------------------------------------------------
        # LIST COMMENTS

        $user = App\User::all();
        $shoppingListForItem = App\ShoppingList::all();

        $comment1 = new App\ListComment;
        $comment1->comment = 'Ich bin mit dem Einkauf fertig';
        $comment1->user()->associate($user[0]);
        $comment1->shoppingList()->associate($shoppingListForItem[1]);
        $comment1->save();

        $comment2 = new App\ListComment;
        $comment2->comment = 'Danke für den Einkauf';
        $comment2->user()->associate($user[1]);
        $comment2->shoppingList()->associate($shoppingListForItem[1]);
        $comment2->save();

    }
}
