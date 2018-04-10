$('#recherche').keyup(
    function () {
        var texte = $('#recherche').val();
        var DATA = 'recherche='+texte;
        $.ajax({
            type : "POST",
            url : "{{ path('tout_les_joueur') }}",
            data:DATA,
            success: function (data) {
                console.log(data);
                /*$('#bloc_joueurs').html("<table id='res' border=1>"+
                    "<th>ID</th>" +
                    "<th>Série</th>" +
                    "<th>Date Mise Circulation</th>" +
                    "<th>Marque</th>" +
                    "<th>Modele</th>"+
                    "</table>");*/
                $.each(data,function (k,el) {
                    $('#bloc_joueurs').append(
                    "<div class='col-lg-3 col-sm-4 col-xs-6 r-full-width'>"+
                        "<div class='team-column'>"+
                        "<img src='http://localhost/Pi/image/"+ el.image +"' alt='' height=269 width=416>"+
                        "<span class='player-number'>"+ el.numero +"</span>"+
                    "<div class='team-detail'>"+
                        "<h5><a href='"+""+"' >"+ el.nom +"</a></h5>"+
                    "<span class='desination'>"+el.nom +"</span>"+
                    "<div class='detail-inner'>"+
                        "<ul>"+
                        "<li>nom</li>"+
                        "<li>prenom</li>"+
                        "<li>age</li>"+
                        "<li>poste</li>"+
                        "<li>club</li>"+
                        "<li>Equipe</li>"+
                        "<li>Follow us on</li>"+
                    "</ul>"+
                    "<ul>"+
                    "<li>"+ el.nom +"</li>"+
                    "<li>"+ el.prenom +"</li>"+
                    "<li>"+ el.age +"</li>"+
                    "<li>"+ el.poste +"</li>"+
                    "<li>"+ el.club +"</li>"+
                    "<li>"+ el.idEquipe.nom +"</li>"+
                    "<li>"+
                    "<ul class='social-icons'>"+
                        "<li><a class='facebook' href='#'><i class='fa fa-facebook'></i></a></li>"+
                    "<li><a class='twitter' href='#'><i class='fa fa-twitter'></i></a></li>"+
                    "<li><a class='youtube' href='#'><i class='fa fa-youtube-play'></i></a></li>"+
                    "<li><a class='pinterest' href='#'><i class='fa fa-pinterest-p'></i></a></li>"+
                    "</ul>"+
                    "</li>"+
                    "</ul>"+
                    "</div>"+
                    "</div>"+
                    "</div>"+
                    "</div>"
                    );
                })
            }
        })
    }
)