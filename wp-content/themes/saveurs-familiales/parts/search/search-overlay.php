<div class="search__overlay">
    <span class="close"><?php _e('Fermer', 'par-design-theme'); ?><span>&times;</span></span>
    <div class="in__search">
        <h2><?php _e('Rechercher', 'par-design-theme'); ?></h2>
        <form action="<?php echo home_url(); ?>" method="get">
            <label>
                <input type="search" class="search-field" placeholder="<?php _e('Recherche', 'par-design-theme') ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" type="text" name="s" id="search">
            </label>
            <input type="hidden" name="custom_search" value="true" id="search">
            <button type="submit" class="search-submit"><svg class="fa fa-search"><use xlink:href="#fa-search"></use></svg></button>
        </form>
    </div>
</div>

