<?php

?>

<form role="search" class="search-form" id="searchForm" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="input-container search-controls">
        <label class="search-form__label" for="search-input"></label>
        <input type="search" class="search-form__input" name="search-input" value="<?php echo esc_attr( get_search_query() ); ?>">
    </div> 
    <div class="input-container search-controls">
        <button type="submit" class="search-form__button">Search</button>
    </div>
    <div class="input-container">
        <div class="search-form__search" id="searchFormSearch">
            <div class="search-form__search-icon" id="searchFormSearchIcon"></div>
            <div class="search-form__close-search-icon" id="searchFormCloseSearchIcon"></div>
        </div>
    </div>
</form>
