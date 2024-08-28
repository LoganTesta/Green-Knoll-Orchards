
window.addEventListener( "load", function () {
    
    let numberOfTestimonialEllipsis = document.getElementsByClassName( "testimonial__ellipsis" ).length;
    for ( let i = 0; i < numberOfTestimonialEllipsis; i++ ) {
        let currentEllipsis = document.getElementsByClassName( "testimonial__ellipsis" )[i];
        currentEllipsis.addEventListener( "click", function(){
            toggleShowRestOfTestimonial(i);
        }, false);
    }
    
    function toggleShowRestOfTestimonial( testimonialWithEllipsisNumber ) {
        document.getElementsByClassName( "testimonial__content" )[testimonialWithEllipsisNumber].classList.toggle( "open-whole-testimonial" );
    }

}, "false");
