
window.addEventListener( "load", function () {

    let numberOfTestimonials = document.getElementsByClassName("testimonial").length;     

    for ( let i = 0; i < numberOfTestimonials; i++ ) {
        let currentTestimonial = document.getElementsByClassName("testimonial")[i];
        let descendantEllipsesThatCanToggle = currentTestimonial.querySelectorAll(".testimonial__ellipsis.can-toggle");
        if ( descendantEllipsesThatCanToggle.length > 0 ) {
            let currentEllipsis = descendantEllipsesThatCanToggle[0];
            currentEllipsis.addEventListener( "click", function(){
                toggleShowRestOfTestimonial(i);
            }, false);
        }
    }
    
    function toggleShowRestOfTestimonial( testimonialWithEllipsisNumber ) {
        document.getElementsByClassName( "testimonial__content" )[testimonialWithEllipsisNumber].classList.toggle( "open-whole-testimonial" );
    }

}, "false");
