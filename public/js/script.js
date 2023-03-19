function getAnime(listAnime){
    let a = '';
    let i = 0;
    listAnime.forEach((anime) => {
        a += `<div class="card p-2 mb-4 mx-3 col-sm-3" style="width: 14rem;">
        <img src="${anime.img}" class="card-img-top" alt="${anime.judul}">
        <div class="card-body">
            <h6 class="card-title">${anime.judul}</h6>
            <p class="card-text">Genre : ${anime.genre.join(',')}</p>
            </div>
            <button class="btn btn-primary more" data-bs-toggle="modal" data-bs-target="#anime" data-id="${i}">More</button>
        </div>`;
        i++;    
    });
    return a;
}




$('#search').click(()=>{
    let data = []
    let query = $('#query').val();
    let rank = $('#rank').val();
    if (!query || !rank){
        alert('Masukan Query');
    }else{
        $.ajax({
            url:'/search',
            method:'GET',
            data:{
                query,
                rank
            },
            dataType:'json',
            success:(data)=>{
                $('.content').html(getAnime(data));
                
                i=0
                data.forEach(anime => {
                    $(`button[data-id=${i}]`).click(function(){
                        // edit modal
                        $('.img-nime').attr('src',anime.img);
                        $('#judul').html(anime.judul);
                        $('#genre').html(anime.genre.join(','));
                        $('#rating').html(anime.rating);
                        $('#sinopsis').html(anime.sinopsis);
                        $('#link').attr('href',anime.link);
                    });
                    i++
                });
            }
        })
    };
    
});


