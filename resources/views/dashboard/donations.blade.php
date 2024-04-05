@extends('dashboard.admin')

@section('content')
    <!-- Table to display users -->
    <div id="users-table" class="container allContent-section py-4">
        <h2>All Donations</h2>  
        <table class="table ">
            <thead>
                <tr>
                    <th class="text-center">Full Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">City</th>
                    <th class="text-center">State</th>
                    <th class="text-center">Postal</th>
                </tr>
            </thead>
            {{-- <tbody id="users-data">
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center">{{ $user->name }}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">{{ $user->joining_date }}</td>
                        <td class="text-center">{{ $user->role }}</td>
                    </tr>
                @endforeach
            </tbody> --}}
        </table>
    </div>
@endsection
