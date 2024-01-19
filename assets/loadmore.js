
        var button = document.getElementById('loadmore');
        var paged = button.getAttribute("data-paged");
        var maxPages = button.getAttribute("data-max-pages");
        /**Registering an event for a button click */
        button.addEventListener('click', request);
        async function request() {
                /**Request data ajax */
                const data = new FormData();
                data.append('action', 'loadmore');
                data.append( 'paged', paged );
                /** fetch  request*/
                const request = await fetch('/wp-admin/admin-ajax.php', { method: 'POST', body: data });
                /** error checking*/
                if (request.ok) {
                        const response = await request.text();
                        let parent = document.querySelector('.movies-block');
                        parent.insertAdjacentHTML('beforeend', response);
                        paged++;
                        if (paged == maxPages) {
                                button.remove();
                        }
                }
                else{
                        button.innerHTML = "Error";
                }
                
        }
