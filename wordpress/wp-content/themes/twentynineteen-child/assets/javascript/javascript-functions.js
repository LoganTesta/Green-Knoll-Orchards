
window.addEventListener("load", function() {  

    /*Toggle show/hide for search bar. */
    let searchFormSearchIcon = document.getElementById("searchFormSearchIcon");
    searchFormSearchIcon.addEventListener("click", toggleSearchForm, false);
    
    searchFormSearchIcon.addEventListener("keypress", function(event){
        if (event.key==="Enter") {
            toggleSearchForm();
        }
    });
    
    
    let searchFormCloseSearchIcon = document.getElementById("searchFormCloseSearchIcon");
    searchFormCloseSearchIcon.addEventListener("click", toggleSearchForm, false);
    
    searchFormCloseSearchIcon.addEventListener("keypress", function(event){
        if (event.key==="Enter") {
            toggleSearchForm();
        }
    });
    
    
    function toggleSearchForm() {
        document.getElementById("searchForm").classList.toggle("show");
    }
    
       
}, "false");
