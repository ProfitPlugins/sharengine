(function ( $ ) {
    $.fn.tablePaginator = function(options) {

        var settings = $.extend({
            perPage:4
        }, options);

        var obj = $(this);
        console.log(this);
        // get the number of results

        var results = this.find("tbody").find("tr").length;

        var pages = Math.ceil(results / settings.perPage);


        /*page 2
          el 5 6 7 8
          slice 4-8
        */
        /* page 3
            el 9 10 11 12
            slice 8-12
         */
        function showPage(pageNr)
        {
            obj.find("tbody").find("tr").hide();
            obj.find("tbody").find("tr").slice( (pageNr-1) *settings.perPage, pageNr*settings.perPage).show();



        }
        function addPagination()
        {
            if(pages>=2)
            {
                var html='<div class="module-paginate-bar">';

                for(i=pages; i>=1;i--)
                {
                    if(i==1)
                        html+='<div page-index="'+i+'" class="module-paginate-element active"></div>';
                    else
                        html+='<div  page-index="'+i+'" class="module-paginate-element"></div>';
                }
                html+="</div>";

                obj.after(html);
            }


        }

        addPagination();

        showPage(1);

       obj.parent().on("click", ".module-paginate-element", function(){

           console.log(obj);
            console.log(this);
            var page = $(this).attr('page-index');
            $(this).parent().find('.module-paginate-element').removeClass("active");
            $(this).addClass("active");
            showPage(page);

        });


        return this;
    };

}( jQuery ));