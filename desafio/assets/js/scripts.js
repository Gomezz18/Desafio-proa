
// Datatable
$(document).ready(function(){
    $('#example').DataTable({
      lengthChange: false,
      searching: true,
      "info": false,
      "order": [[ 0, "desc" ]], //Ordena
      lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, 'Todos'],
      ],
      dom: 'Blfrtip',
          "language": {
              "lengthMenu": "Mostrando _MENU_ registros por página",
              "zeroRecords": "Nada foi encontrado",
              "info": "Mostrando página _PAGE_ de _PAGES_",
              "infoEmpty": "Nenhum registro disponível",
              "infoFiltered": "(filtrado de _MAX_ registros no total)",
              "search": "Procurar:",
              "paginate": {
                            "previous": "Anterior",
                            "next": "Próxima"
                          }
                      },
                          
      });
});