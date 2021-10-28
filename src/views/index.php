<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>SAM SSL PAYMENT</title>
    </head>
    <body>
        <form name="myform" action="<?php echo $route ?>" method="post">

            <?php foreach($result as $key=>$item){ ?>
            <input type="hidden" name="<?php echo $key ?>" value="<?php echo $item ?>">

            <?php } ?>
            <input type="hidden" name="message" value="<?php echo $message ?>">
            <input type="hidden" name="status" value="<?php echo $status ?>">

            <button style="display: none;" type="submit" id="submit">Submit</button>
        </form>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

        <script type="text/javascript">

        $(document).ready(function(){
            $('#submit').trigger('click');
        });
        </script>
      
</html>