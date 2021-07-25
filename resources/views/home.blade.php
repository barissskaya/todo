<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title>Laravel</title> 
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="container mt-5 mb-5"> 
            <h1 class="text-center mb-5">İş Yapma Programı</h1>
            <div class="row" id="devs-root"></div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>  
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
        <script>
            const getDevelopers = () => {
                fetch('{{ route("developers") }}')
                .then((response) => response.json())
                .then((res) => { 
                    
                    if(res.status === 'ok'){ 
                        let {datas} = res; 
                        let accordionItemsHtml = '';
                        let maxWeeks = 0;                                                            
                        datas.forEach((data, i) => {     
                            if(data.totalWeek > maxWeeks){
                                maxWeeks = data.totalWeek;
                            }  
                            
                            let weeksHtml = '';
                            for (weekNumber in data.weeks) { 
                                let currentWeek = data.weeks[weekNumber];

                                let weekTasksHtml = ''; 
                                currentWeek.tasks.forEach((task, i) => { 
                                    weekTasksHtml += ` 
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                        <div>${task.name}</div> 
                                        </div>
                                        <span class="badge bg-primary rounded-pill">${task.duration} saat</span>
                                    </li> `;
                                }); 

                                weeksHtml += ` 
                                    <div class="col-12 col-md-6">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Hafta ${weekNumber}</h5>
                                                <h6 class="card-subtitle mb-2 text-muted">Toplam süre: ${currentWeek.duration} saat</h6>
                                                <p class="card-text mb-1 mt-4"><strong>Görevler</strong></p> 
                                                <ul class="list-group  list-group-numbered list-group-flush">
                                                ${weekTasksHtml}
                                                </ul>
                                            </div>
                                        </div> 
                                    </div>
                                `; 
                            } 

                            accordionItemsHtml += ` 
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="dev-${i}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dev-accordion-${i}" aria-expanded="false" aria-controls="dev-accordion-${i}">
                                        <i class="fas fa-user fa-sm me-2"></i>${data.name} (${data.totalWeek} Hafta)
                                        </button>
                                    </h2>
                                    <div id="dev-accordion-${i}" class="accordion-collapse collapse" aria-labelledby="dev-${i}" data-bs-parent="#developersAccordion">
                                        <div class="accordion-body"><div class="row">${weeksHtml}</div></div>
                                    </div>
                                </div> 
                            `; 
                        });  

                        let accordionHtml = `  
                            <div class="accordion accordion-flush" id="developersAccordion">
                                ${accordionItemsHtml} 
                            </div>  
                        `;

                        $('#devs-root').html(accordionHtml);
                        $('#devs-root').prepend(`<h2 class="mb-5">İş <strong>${maxWeeks}</strong> hafta sürecek</h2>`)
                    
                    }else{
                        console.log(res.message);
                    }
                }) 
            } 
            getDevelopers();
        </script>
    </body>
</html>
