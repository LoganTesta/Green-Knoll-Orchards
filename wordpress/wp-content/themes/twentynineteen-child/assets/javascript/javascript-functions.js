
window.addEventListener("load", function() {  

    /*Toggle show/hide for search bar. */
    let searchFormSearch = document.getElementById("searchFormSearch");
    searchFormSearch.addEventListener("click", toggleSearchForm, false);
    
    function toggleSearchForm() {
        document.getElementById("searchForm").classList.toggle("show");
    }
       
}, "false");
