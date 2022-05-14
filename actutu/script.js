function base() {

    search = JSON.stringify(document.getElementById(`cherche1`).value);
    document.querySelector('#article').innerHTML = ""
    document.querySelector('#vingt').innerHTML = ""



    //let aaaa = document.getElementsByClassName('remove');
    //search1 = JSON.stringify(document.getElementById(`cherche1`).value);

    if(search === '""'){

        search = "ecmascript"
    }
    console.log(search)

    let lien = `https://www.googleapis.com/books/v1/volumes?q=` + search.replace(/"([^"]+(?="))"/g, '$1', / /g, '-');


    fetch(lien)
        .then(response => response.json())
        .then(data => {
            for (let i = 0; i < 3; i++) {

                let image = data.items[i].volumeInfo.imageLinks?.thumbnail
                let titre = data.items[i].volumeInfo.title
                let auteur = data.items[i].volumeInfo.authors
                let prix = data.items[i].saleInfo.listPrice?.amount
                let lien = data.items[i].volumeInfo?.infoLink


                if (typeof image === 'undefined') {

                    image = "noimage.jpg";
                }


                if (typeof prix === "undefined") {

                    prix = "indisponible"
                }


                let listItem = `
                            <div><a class="lienbook" href="${lien}">
                                <img src="${image}" alt="">
                                <h3>${titre}</h3>
                                <h3>${auteur}</h3>
                                <p>${prix}€</p></a>
                            </div>`

                document.querySelector('#article').innerHTML += listItem


            }
        })
        .catch(console.error)

    fetch(lien)
        .then(response => response.json())
        .then(data => {
            for (let b = 0; b < 9; b++) {

                let image1 = data.items[b].volumeInfo.imageLinks?.thumbnail
                let titre1 = data.items[b].volumeInfo.title
                let auteur1 = data.items[b].volumeInfo.authors
                let prix1 = data.items[b].saleInfo.listPrice?.amount
                let lien1 = data.items[b].volumeInfo?.infoLink
                let description = data.items[b].searchInfo?.textSnippet


                if (typeof image1 === 'undefined') {

                    image1 = "noimage.jpg";
                }


                if (typeof prix1 === "undefined") {

                    prix1 = "indisponible"
                }


                let bookitem = `
                                <article class="books1"><a href="${lien1}">
                                <article><img class="bookimg" src="${image1}" alt=""></article>
                                <section>
                                <h3>${titre1}</h3>
                                <h3>${auteur1}</h3>
                                <br>
                                <br>
                                <p>${description}</p></a>
                                </section>
                                </article>
                                `

                document.querySelector('#vingt').innerHTML += bookitem


            }
        })


}





//let search = JSON.stringify(document.getElementById(`cherche1`).value);


function add() {

    let menu = document.getElementById('menus')
    let menu1 = document.getElementById('menuss')

    menu.classList.add('visible');
    menu1.classList.add('visible');

}

function remove() {

    let menu = document.getElementById('menus')
    let menu1 = document.getElementById('menuss')

    menu.classList.remove('visible');
    menu1.classList.remove('visible');


}