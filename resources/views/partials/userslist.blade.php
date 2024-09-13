
<table class="table" id="users_table">
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td><i class="fa-regular fa-user text-primary"></i> {{$user->name}}</td>
                <td> <i class="fa-regular fa-envelope text-primary"></i> {{$user->email}}</td>
                <td>
                   @if ($user->role =="Admin")
                   <i class="fa-solid fa-user-shield text-danger"></i> {{$user->role}}
                   @else
                   <i class="fa-solid fa-user-tie text-primary"></i> {{$user->role}}
                   @endif
                </td>
                <td>
                    @if ($user->status==1)
                    <i class="fa-solid fa-circle text-success"></i> Active
                    @else
                    <i class="fa-solid fa-circle text-danger"></i> Locked
                    @endif
                   
                </td>
            </tr>
        @endforeach
    </tbody>
</table>