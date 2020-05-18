<ul>
    @foreach($shoppingLists as $shoppingList)
        <li>{{ $shoppingList->title }}</li>
    @endforeach
</ul>