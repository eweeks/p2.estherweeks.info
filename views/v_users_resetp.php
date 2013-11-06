<form method='POST' action='/users/p_reset'>

    New Password<br>
    <input type='password' name='password'>
    <br><br>

    <input type='submit' value='Reset'>

</form> 
    <?php if(isset($error)): ?>
        <div class='error'>
            <p>Fields must be set</p>
        </div>
        <br>
    <?php endif; ?>