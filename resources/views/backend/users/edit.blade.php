@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Update user</h1>
        <div class="lead">
            
        </div>
        
        <div class="container mt-4">
            <form method="post" action="{{ route('users.update', $user->id) }}" autocomplete="off">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="@if(old('name')){{old('name')}}@elseif(empty(old('name')) && old('_token')) {{''}}@else{{Arr::get($user,'name')}}@endif" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="Name" >
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input value="@if(old('email')){{old('email')}}@elseif(empty(old('email')) && old('_token')) {{''}}@else{{Arr::get($user,'email')}}@endif"
                        type="email" 
                        class="form-control" 
                        name="email" 
                        placeholder="Email address" >
                   
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input value="@if(old('username')){{old('username')}}@elseif(empty(old('username')) && old('_token')) {{''}}@else{{Arr::get($user,'username')}}@endif"
                        type="text" 
                        class="form-control" 
                        name="username" 
                        placeholder="Username" >
                    
                </div>
                <div class="mb-3">
                    <label for="PassWord" class="form-label">PassWord</label>
                    <div class="row" >
                        <div class="col-sm-6">
                        <input type="password" autocomplete="off" class="form-control" id="password" placeholder="Enter Password" name="password" maxlength="20" readonly onclick="this.removeAttribute('readonly');">
                        </div>
                        <div class="col-sm-6">
                        <input type="password" autocomplete="off" class="form-control" id="confirm_password" placeholder="Enter Confirm Password" name="confirm_password" maxlength="20" readonly onclick="this.removeAttribute('readonly');">
                        </div> 
                </div>
                
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-control" 
                        name="role" rel="{{old('role')}}" >
                        <option value="">Select role</option>
                        @foreach($roles as $role)
                            
                        @if(old('role') == Arr::get($role, 'id'))
                            <option value="{{ trim(Arr::get($role, 'id')) }}" selected>{{trim(Arr::get($role, 'name'))}}</option>
                        @elseif(old('_token') == null ))
                            <option value="{{ $role->id }}"
                                {{ in_array($role->name, $userRole) 
                                    ? 'selected'
                                    : '' }}>{{ $role->name }}</option>
                        @else                 
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endif            
                        @endforeach
                    </select>
                    
                </div>

                <button type="submit" class="btn btn-primary">Update user</button>
                <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</button>
            </form>
        </div>

    </div>
@endsection
