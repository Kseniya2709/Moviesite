
    const search_input = document.querySelector(".search-field");
    const search_results = document.querySelector(".result-search");
    /**Registering an event for a keyup for search */
    search_input.addEventListener("keyup",search);
    async function search() {
        let search_value = this.value;
        if (search_value.length > 2) { // if there are more than 2 characters, start the search
            /**Request data ajax */
                const data = new FormData();
                data.append('action', 'ajax_search');
                data.append( 'term', search_value );
                /** fetch  request*/
                const request = await fetch('/wp-admin/admin-ajax.php', { method: 'POST', body: data });
                /** error checking*/
                if (request.ok) {
                    const response = await request.text();
                    fadeIn (search_results, 200, 'block');
                    search_results.innerHTML = response;
                }
                else{
                    fadeIn (search_results, 200, 'block');
                    search_results.innerHTML = '<li class="result-search-item" style="color:red;">There was an error while searching</li>';
                }

        } else {
                fadeOut (search_results,200);
        }
        }
        // Closing the search when clicking outside of it

        document.addEventListener('mouseup', function(e) {
            if (!search_input.contains(e.target) && !search_results.contains(e.target)) {
                fadeOut (search_results,200);

            }
        });
        // Show results
        const fadeIn = (el, timeout, display) => {
                el.style.opacity = 0;
                el.style.display = display || 'block';
                el.style.transition = `opacity ${timeout}ms`;
                setTimeout(() => {
                el.style.opacity = 1;
                }, 10);
            };
        // Hide results
        const fadeOut = (el, timeout) => {
                el.style.opacity = 1;
                el.style.transition = `opacity ${timeout}ms`;
                el.style.opacity = 0;
            
                setTimeout(() => {
                el.style.display = 'none';
                }, timeout);
            };