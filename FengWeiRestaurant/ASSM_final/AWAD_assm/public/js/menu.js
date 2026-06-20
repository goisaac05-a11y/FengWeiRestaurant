function searchMenu() {
    let input = document.getElementById('search').value.toLowerCase();
    let categories = document.querySelectorAll('h1[id]');
    
    categories.forEach(cat => {
        let menuDiv = cat.nextElementSibling;
        let items = menuDiv.querySelectorAll('.item');
        let matchCount = 0;
        
        items.forEach(item => {
            let name = item.querySelector('h3').innerText.toLowerCase();
            if(name.includes(input)) {
                item.style.display = "block";
                matchCount++;
            } else {
                item.style.display = "none";
            }
        });

        if(matchCount > 0) {
            cat.style.display = "block";
            menuDiv.style.display = "grid";
        } else {
            cat.style.display = "none";
            menuDiv.style.display = "none";
        }
    });
}

window.addEventListener('scroll', function() {
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        const scrollY = window.scrollY;
        sidebar.style.top = scrollY > 80 ? '140px' : (140 - scrollY) + 'px';
    }
});