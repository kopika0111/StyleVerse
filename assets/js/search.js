$(document).ready(function() {
    $("#search-box").on("keyup", function() {
        let query = $(this).val().trim();

        if (query.length > 1) {
            $.ajax({
                url: "/StyleVerse/actions/search_with_history.php", 
                method: "GET",
                data: { query: query },
                dataType: "json",
                success: function(response) {
                    let resultsContainer = $("#search-results");
                    resultsContainer.empty();

                    if (response.length > 0) {
                        response.forEach(product => {
                            resultsContainer.append(`
                                <a href="/StyleVerse/views/products/product_details.php?product_id=${product.product_id}" class="search-item">
                                    <img src="/StyleVerse/assets/images/products/${product.image_url}" alt="${product.name}" class="search-thumb">
                                    <div>
                                        <p class="search-name">${product.name}</p>
                                        <p class="search-category">${product.category_name} > ${product.subcategory_name}</p>
                                    </div>
                                </a>
                            `);
                        });
                        resultsContainer.show();
                    } else {
                        resultsContainer.html("<p class='no-results'>No products found</p>").show();
                    }
                }
            });
        } else {
            $("#search-results").hide();
        }
    });

    $(document).on("click", function(e) {
        if (!$(e.target).closest("#search-container").length) {
            $("#search-results").hide();
        }
    });
});
