<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="m-2 mb-4">User Information</h3>
            <table class="table">
                <tr>
                    <td>Name</td>
                    <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>{{ $user->user_info->phone }}</td>
                </tr>
                <tr>
                <tr>
                    <td>Birthday</td>
                    <td>{{ \Carbon\Carbon::parse($user->user_info->birthday)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>{{ $user->user_info->address }}</td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td>{{ $user->user_info->country }}</td>
                </tr>
                <tr>
                    <td>Postcode</td>
                    <td>{{ $user->user_info->postcode }}</td>
                </tr>
                <tr>
                    <td>Province</td>
                    <td>{{ $user->user_info->province }}</td>
                </tr>
                <tr>
                    <td>Last Login</td>
                    <td>{{ \Carbon\Carbon::parse($user->last_login)->format('h:i:s A | D, d M Y') }}</td>
                </tr>
                <tr>
                    <td>Created</td>
                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('D, d M Y') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>