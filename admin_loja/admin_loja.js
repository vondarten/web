let url = '../test.json';

fetch(url)
.then(res => {
    for (var i = 0; i < response.length; i++) {
        var row = `<tr>
                  <td>${response[i].id}</td>
                  <th>${response[i].peso}kg</th>
                  <th>${response[i].altura}cm x${response[i].largura}cm x${response[i].profundida}cm</th>
                  <th>${response[i].dataPrevista}</th>
                  <th>${response[i].destinario.nome}</th>
                  <th>${response[i].status.name}</th>
                  <th>${response[i].observacao}</th>
                  </tr>`;

        // Append the row to the table body
        $('#table-body').append(row);
        }
})
.then(out =>
  console.log('Checkout this JSON! ', out))
.catch(err => { throw err });

// document.ready(function() {
//     // Fetch data from the backend API
//     // $.ajax({
//     //   url: 'http://127.0.0.1:5500/test.json', // Replace with your backend API endpoint
//     //   method: 'GET',
//     //   success: function(response) {
//         // Iterate over the data and create table rows
//         response = JSON.parse({
//             "id": 1,
//             "peso": "teste",
//             "altura":"teste",
//             "largura":"teste",
//             "profundida":"teste",
//             "dataPrevista":"teste",
//             "destinario" : {
//                 "nome": "teste"
//             },
//             "status" : {
//                 "name": "teste"
//             },
//             "observacao": "teste"
//         })
//         for (var i = 0; i < response.length; i++) {
//           var row = `<tr>
//                     <td>${response[i].id}</td>
//                     <th>${response[i].peso}</th>
//                     <th>${response[i].altura}cm x${response[i].largura}cm x${response[i].profundida}cm</th>
//                     <th>${response[i].dataPrevista}</th>
//                     <th>${response[i].destinario.nome}</th>
//                     <th>${response[i].status.name}</th>
//                     <th>${response[i].observacao}</th>
//                     </tr>`;
  
//           // Append the row to the table body
//           $('#table-body').append(row);
//         }
//     //   },
//     //   error: function() {
//     //     console.log('Error fetching data from the backend.');
//     //   }
//     // });
//   });