<div>
    <form wire:submit='store' method="POST">
        @csrf
        <input type="text" wire:model="name">
        <input type="text" wire:model="email">
        <input type="text" wire:model="password">
        <button type="submit">Submit</button>
    </form>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr wire:key='{{$user->id}}'>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
