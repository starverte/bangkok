<?php
  $options = get_option('bangkok_theme_options');
?>

<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <div><label class="screen-reader-text" for="s">Search for:</label>
        <input type="text" name="s" id="s" value="<?php echo $options['s_text']; ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
        <input type="submit" id="searchsubmit" value="Search" />
    </div>
</form>
