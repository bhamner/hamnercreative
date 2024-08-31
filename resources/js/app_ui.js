DocReady( () => {

	//delete confirmation for user account
	if ($('#deleteConfirmationCode').length ){
   		$("input#deleteConfirmationCode").keyup(function(){
	      if ($("input#deleteConfirmationCode").val() == $("#deleteCode").html() ){
	      	$("#submitDelete").prop("disabled", false);
	      }
		});
	}

    if ($('.slide-5').length ){
        $('.slide-5').each( function(e) {
            const alertDiv = $(this);
            setTimeout(function(){ 
                alertDiv.fadeTo(500,0).slideUp(500,function(){
                    $(this).remove();
                });
                },4000);
 
        });
    }

    //make clickable table rows
    $(".clickable-row").css( 'cursor', 'pointer' );
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });

    //Quill
    if ($('#quill').length ){
        const quill = new Quill("#quill", {
            theme: "snow",
          });
        //append quill content to parent form on submit
        const form = document.querySelector('form');
        form.addEventListener('formdata', (event) => {
          // Append Quill content before submitting
          event.formData.append('quill_contents', JSON.stringify(quill.getContents().ops));
        });
    }

    //bootstrap tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
 
    //select2
    $('.select2').select2();
 
    //clone and append services input
    $('#service-div').on("keyup", function(e){
        const lastRowInputsAreFilled = $("#service-div :last-child input").filter( function(){ 
            return $.trim($(this).val()).length === 0;
        }).length == 0;
        if( lastRowInputsAreFilled ){
            const clonedElement =  $("#service-div .row").last().clone();
            clonedElement.find('input').val('');
            $('#service-div').append(clonedElement);
        }
    });

    //delete parent row
     $('.delete-parent-row').on('click', function(e){
        e.preventDefault();
        if( $('.delete-parent-row').length > 1 ){
            $(this).closest('.row').remove();
        }
     });
     

    //table tag requires data attributes: 
    //search: bool
    //paginate: bool
    //col: index number of the default sort col
    //dir: default sort direction
    //placeholder: empty table message
    if($('table.dataTable').length){
        $('table.dataTable').each(function(index) {
           let table = $(this);
             let tableref = new DataTable( table ,{
    			order: [[table.data('col'),table.data('dir')]],
                paging: table.data('paginate'),
                searching: table.data('search'),
                layout: {
				    topEnd: ['search','buttons'],
				    bottomStart: 'info',
				    bottomEnd: 'paging'
			    },
                buttons: [ {
                    extend:    'csv',
                    text:'CSV',
                    titleAttr: 'Export CSV',
                    className: 'btn btn-sm btn-outline-secondary d-none d-sm-block'
                }],
                language: {
                    emptyTable: table.data('placeholder'),
                }
            }); 

        });
    }

    //chart.js
    const lineCharts = ["line-chart"];
    lineCharts.forEach(function(name){
        if($("#"+name).length > 0) create_line_chart(name);
    });

    function create_line_chart(elem_id){
        const item = document.getElementById(elem_id);
        const ctx = item.getContext('2d');
        const title = item.getAttribute('data-title');
        const labels = JSON.parse(item.getAttribute('data-labels'));
        const points =  JSON.parse(item.getAttribute('data-points'));
        const color =  JSON.parse(item.getAttribute('data-color'));

        const newLineChart = new Chart(ctx, {
            type: 'line',
            maintainAspectRatio: false,
            responsive: true,
            data: {
                labels: labels,
                datasets: [{
                    label: title,
                    backgroundColor: color,
                    borderColor: color,
                    data: points,
                    fill: false,
                }]
            },
            options: {
              scale: {
                ticks: {
                  precision: 0
                }
              }
            }
        });
    }

    const multiLineCharts = ["multi-line-chart"];
    multiLineCharts.forEach(function(name){
        if($("#"+name).length > 0) create_multi_line_chart(name);
    });

    function extractColumn(arr, column) {
        function reduction(previousValue, currentValue) {
            previousValue.push(currentValue[column]);
            return previousValue;
        }

        return arr.reduce(reduction, []);
    }

    function create_multi_line_chart(elem_id){
        const item = document.getElementById(elem_id);
        const ctx = item.getContext('2d');
        const labels = JSON.parse(item.getAttribute('data-labels'));
        const total = item.getAttribute('data-total');
        const data_points = [];

        for(let i=0;i<total;i++){
            const color = randomColor(i);
            data_points.push({
                label: item.getAttribute('data-title-'+i),
                backgroundColor: color ,
                borderColor: color,
                data: JSON.parse(item.getAttribute('data-points-'+i)),
                fill: false,
            })
        }

        const pointsArray = extractColumn(data_points, 'data');
        const points = [].concat.apply([], pointsArray);
        const chartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: data_points
            },
            options: {
              scale: {
                ticks: {
                  precision: 0
                }
              }
            }
        });
    }

    function randomColor(index){
        //from kelly's 22 colors of maximum contrast + halftones
        var colors = [
            'rgba(130,188,0,0.5)',
            'rgba(66,150,180,0.5)',
            'rgba(247,148,29,0.5)',
            'rgba(135,86,146,0.5)',
            'rgba(243,195,0,0.5)',
            'rgba(161,202,241,0.5)',
            'rgba(190,0,50,0.5)',
            'rgba(194,178,128,0.5)',
            'rgba(230,143,172,0.5)',
            'rgba(89,133,60,0.5)',
            'rgba(132,132,130,0.5)',
            'rgba(249,147,121,0.5)',
            'rgba(96,78,151,0.5)',
            'rgba(246,166,0,0.5)',
            'rgba(179,68,108,0.5)',
            'rgba(220,211,0,0.5)',
            'rgba(136,45,23,0.5)',
            'rgba(226,88,34,0.5)',
            'rgba(43,61,38,0.5)',
            'rgba(101,69,34,0.5)',
            'rgba(130,188,0,0.9)',
            'rgba(66,150,180,0.9)',
            'rgba(247,148,29,0.9)',
            'rgba(135,86,146,0.9)',
            'rgba(243,195,0,0.9)',
            'rgba(161,202,241,0.9)',
            'rgba(190,0,50,0.9)',
            'rgba(194,178,128,0.9)',
            'rgba(230,143,172,0.9)',
            'rgba(89,133,60,0.9)',
            'rgba(132,132,130,0.9)',
            'rgba(249,147,121,0.9)',
            'rgba(96,78,151,0.9)',
            'rgba(246,166,0,0.9)',
            'rgba(179,68,108,0.9)',
            'rgba(220,211,0,0.9)',
            'rgba(136,45,23,0.9)',
            'rgba(226,88,34,0.9)',
            'rgba(43,61,38,0.9)',
            'rgba(101,69,34,0.9)'
        ]
        var total = colors.length;
        while (index > total) {
            var subtractor = total * Math.round(index/total);
            index = Math.abs(index - subtractor);
        }
        return colors[index];
    };

});// end docready




