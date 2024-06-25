@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Add new user</h1>
        <div class="lead">
            Add new user and assign role.
        </div>

        <div class="container mt-4">
            <form method="POST" action="">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ old('name') }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="Name">

                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input value="{{ old('email') }}"
                        type="email" 
                        class="form-control" 
                        name="email" 
                        placeholder="Email address">
                    
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input value="{{ old('username') }}"
                        type="text" 
                        class="form-control" 
                        name="username" 
                        placeholder="Username">
                   
                </div>

                <div class="mb-3">
                    <label for="PassWord" class="form-label">PassWord</label>
                    <div class="row" >
                        <div class="col-sm-6">
                        <input type="password" autocomplete="off" class="form-control" id="password" placeholder="Enter Password" name="password" maxlength="20">
                        </div>
                        <div class="col-sm-6">
                        <input type="password" autocomplete="off" class="form-control" id="confirm_password" placeholder="Enter Confirm Password" name="confirm_password" maxlength="20">
                        </div> 
                </div>
                
                <div>&nbsp;</div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save user</button>
                    <a href="{{ route('users.index') }}" class="btn btn-default">Back</a>
                </div>
            </form>
        </div>

    </div>
@endsection
