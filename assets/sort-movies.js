let elements = document.querySelectorAll('.filter');

for (let sort of elements) {
    sort.onchange = async function() {
        
        let form = new FormData( document.getElementById('sort-form'));
        form.append('action', 'sort_movies');
        const request = await fetch('/wp-admin/admin-ajax.php', { method: 'POST', body: form });
                /** error checking*/
                if (request.ok) {
                        const response = await request.text();
                        let parent = document.querySelector('.movies-block');
                        parent.innerHTML = response;
                }
                else{
                        parent.innerHTML = "Error";
                }
        
    }
}
