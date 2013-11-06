<form method='POST' action='/posts/p_add'>

    <label for='content'>New Post:</label><br>
    <textarea name='content' id='content'></textarea>

    <br><br>
    <input type='submit' value='New post'>

</form> 

    <?php if(isset($error)): ?>
        <div class='error'>
            <p>You must have something to say...</p>
            <p>Please enter some text</p>
        </div>
        <br>
    <?php endif; ?>