// carousel setup
window.addEventListener('load', function() {
    document.querySelectorAll('.carousel').forEach(carousel => {
        let childlen = carousel.children.length;
        carousel.style.width = childlen * 100 + '%'; //##
        
        let move_children = index => {
            [...carousel.children].forEach(child => {
                child.style.left = -100 / childlen * index + '%';
            })
        }
        
        carousel.show = function(index) {
            carousel.classList.remove('no-animate');
            move_children(index);
        }
        carousel.show_immediate = function(index) {
            carousel.classList.add('no-animate');
            move_children(index);
        }
        
        carousel.show(0); // fixes animation not playing on first use
    })
})