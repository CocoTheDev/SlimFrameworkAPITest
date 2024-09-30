 <h1>Hello Worldiii</h1>

 <?php if (empty($_SESSION['user_id'])): ?>

    <a href="/signup">Sign up to get an API key</a>
    <br>
    or
    <br>
    <a href="/login">Login</a>

<?php else: ?>

    <a href="/profile">View Profile</a>
    <br>
    or
    <br>
    <a href="/logout">Log out</a>
    
<?php endif; ?>