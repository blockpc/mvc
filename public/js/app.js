document.querySelectorAll(".setMode").forEach(item => 
    item.addEventListener("click", () => {
        if ( item.id == 'dark' ) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', '');
        }
    })
)