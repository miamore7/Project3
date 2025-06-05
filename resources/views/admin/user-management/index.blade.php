@foreach($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            <form method="POST" action="{{ route('admin.users.reset-password-default', $user->id) }}">
                @csrf
                <button type="submit" class="btn btn-warning" onclick="return confirm('Reset password to default?')">
                    Reset to Default Password
                </button>
            </form>
        </td>
    </tr>
@endforeach