const libros = [

    {
        titulo:"El almohadón de plumas",
        imagen:"assets/img/plumas.jpg",
        autor:"Horacio Quiroga",
        precio: 500
    },

    {
        titulo:"Juego de Tronos",
        imagen:"assets/img/tronos.jpg",
        autor:"George R. R. Martin",
        precio: 1500
    },

    {
        titulo:"El principito",
        imagen:"assets/img/principito.jpg",
        autor:"Antoine de Saint-Exupéry",
        precio: 800
    }

];

const audiolibros = [

    {
        titulo:"Alicia en el País de las Maravillas",
        imagen:"assets/img/audiolibro1.jpg",
        autor:"Lewis Carroll",
        precio: 1200
    },

    {
        titulo:"Biomoléculas",
        imagen:"assets/img/audiolibro2.jpg",
        autor:"Dr. Juan Pérez",
        precio: 900
    },

    {
        titulo:"Blancanieves",
        imagen:"assets/img/audiolibro3.jpg",
        autor:"Hermanos Grimm",
        precio: 1100
    }

];

let contenedorLibros =
    document.getElementById("contenedorLibros");

for(let libro of libros){

    contenedorLibros.innerHTML += `

        <div class="col-md-4 mb-4">

            <div class="card">

                <img
                    src="${libro.imagen}"
                    class="card-img-top">

                <div class="card-body text-center">

                    <h5>${libro.titulo}</h5>
                    <p class="card-text">${libro.autor}</p>
                    <p class="card-text"> $${libro.precio}</p>
                </div>

            </div>

        </div>

    `;
}

let contenedorAudiolibros =
    document.getElementById("contenedorAudiolibros");

for(let audio of audiolibros){

    contenedorAudiolibros.innerHTML += `

        <div class="col-md-4 mb-4">

            <div class="card">

                <img
                    src="${audio.imagen}"
                    class="card-img-top">

                <div class="card-body text-center">

                    <h5>${audio.titulo}</h5>
                    <p class="card-text">${audio.autor}</p>
                    <p class="card-text"> $${audio.precio}</p>

                </div>

            </div>

        </div>

    `;
}