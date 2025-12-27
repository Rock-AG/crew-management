<form action="{{ route('login.store') }}" method="POST">
    @csrf
    <input type="text" name="email">@error('email') email error bla @enderror
    <input type="password" name="password">@error('password') password error bla @enderror
    <input type="submit" value="Login">
</form>