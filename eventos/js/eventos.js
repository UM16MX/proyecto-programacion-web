$( document ).ready( getEventos );


function getEventos(){ 
$.ajax(
    {
        type: "POST",
        dataType:"JSON",
        url: "./GET/?source1=eventos&source2=geteventos",
        //data: {"usuario":usuario, "contra":contrasena}, 
        beforeSend: function(event)
        {
        },
        success: function(server)
        {
          
         if (server.length > 0) 
         {
           $.each(server,function(a,b)
           {
            let fila = interfazUsuario(b);
            $("#contenedorResultados").append(fila);
           });
           
         }          
        //alert(server.nombre);
         

        
        },
        error: function(e)
        {
  console.log(e);         
              //console.log(e);
        }
     });

     
    }
    function interfazUsuario(registro){
      let interface = '<tr id="'+registro.id+'"><td class="col1">'+registro.id+'</td><td class="col2">'+registro.fec_res+'</td><td class="col3">'+registro.desde+'</td><td class="col4">'+registro.hasta+'</td><td class="col5">'+registro.personas+'</td><td class="col6">'+registro.comentarios+'</td><td class="col7">'+registro.fecha+'</td><td class="col8">'+registro.estatus+'</td><td><button type="button" class="btn btn-primary" onclick="getEventoId(\''+registro.id+'\')"> <i class="fas fa-edit"></i> </button><button type="button" class="btn btn-danger" onclick="delEvento(\''+registro.id+'\')"><i class="fas fa-trash-alt"></i></button></td></tr>';
      return interface;
    }

    function registrar() {
        let fec_res = document.getElementById("fec_res").value
        let desde = document.getElementById("desde").value
        let hasta = document.getElementById("hasta").value
        let personas = document.getElementById("personas").value
        let comentarios = document.getElementById("comentarios").value
      //console.log(nombre);
      if (fec_res !="" && desde !="" && hasta !="" && personas !="" && comentarios !="") {
        $.ajax(
          {
              type: "POST",
              dataType: "JSON",
              url: "./POST/?source1=eventos&source2=setevento",
              data: {"fec_res":fec_res, "desde":desde, "hasta":hasta, "personas":personas, "comentarios":comentarios}, 
              beforeSend: function(event)
              {
              },
              success: function(server)
              {
                if (server.estatus=='ok') {
                  Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Evento registrado',
                    showConfirmButton: false,
                    timer: 1900
                  });
                  let registro = {};
                
                registro.id = server.logId
                registro.fec_res = fec_res
                registro.desde = desde
                registro.hasta = hasta
                registro.personas = personas
                registro.comentarios = comentarios
                registro.fecha = server.logFecha
                registro.estatus = 1
                let fila = interfazUsuario(registro);
                $("#contenedorResultados").append(fila);
                }          
                                                     
              },
              error: function(e)
              {
        console.log(e);
                 
                    //console.log(e);
              }
           });
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Llena los campos',
          
          
        })
      }
    
      }

function getEventoId(id){ 
  $("#idevento").val(id);
  $("#modaleditar").modal("show");  
$.ajax(
  {
      type: "POST",
      dataType: "JSON",
      url: "./GET/?source1=eventos&source2=geteventoid",
      data: {"source1":id}, 
      beforeSend: function(event)
      {
      },
      success: function(server)
      {
        $("#fec_res_ed").val(server.fec_res);
        $("#desde_ed").val(server.desde);
        $("#hasta_ed").val(server.hasta);
        $("#personas_ed").val(server.personas);
        $("#comentarios_ed").val(server.comentarios);
        
      //alert(server.nombre);      

      },  
      error: function(e)
      {
        console.log(e);
      }
    });
}

function editar() {
        
        let idEvento = $("#idevento").val();
        let fec_res = $("#fec_res_ed").val();
        let desde = $("#desde_ed").val();
        let hasta = $("#hasta_ed").val();
        let personas = $("#personas_ed").val();
        let comentarios = $("#comentarios_ed").val();
        
    //console.log(nombre);
    $.ajax(
  {
      type: "POST",
      dataType: "JSON",
      url: "./POST/?source1=eventos&source2=updeventoid",
      data: {"idevento":idEvento, "fec_res_ed":fec_res, "desde_ed":desde, "hasta_ed":hasta, "personas_ed":personas, "comentarios_ed":comentarios}, 
      beforeSend: function(event)
      {
      },
      success: function(server)
      {
        if (server.estatus=='ok') {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Evento editado',
            showConfirmButton: false,
            timer: 1800
          })
          $("#"+idEvento+"").find("td.col2").text(fec_res)
          $("#"+idEvento+"").find("td.col3").text(desde)
          $("#"+idEvento+"").find("td.col4").text(hasta)
          $("#"+idEvento+"").find("td.col5").text(personas)
          $("#"+idEvento+"").find("td.col6").text(comentarios)


        }          
                     
      },
      error: function(e)
      {
console.log(e);
         
            //console.log(e);
      }
   });
  
  }

function delEvento(id) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: "¡No podrás revertir esto!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.value) {
      $.ajax(
        {
          type:"POST",
          dataType: "JSON",
          url: "./POST/?source1=eventos&source2=delevento",
          data: {"id":id},
          beforeSend: function(event)
          {  
          },
          success: function(server)
          {
            if (server.status=='ok') {
              $("#"+id+"").remove();
              Swal.fire(
                'Borrado!',
                'Tu evento fue borrado.',
                'success'
              )  
            }
            
          },
          error: function(e)
          {
            console.log(e);
          }
        });      
      
    }
  })  
  

}





function buscarEvento(){   
let buscar = $("#buscar").val();
$("#contenedorResultados").empty();
  $.ajax(
    {
        type: "POST",
        dataType:"JSON",
        url: "./GET/?source1=eventos&source2=getbuscarevento",
        data: {"fec_res":buscar}, 
        beforeSend: function(event)
        {
        },
        success: function(server)
        {
          if (server.length > 0) 
          {
            $.each(server,function(a,b)
            {
             let fila = interfazUsuario(b);
             $("#contenedorResultados").append(fila);
            });
            
          }          
         
        },          
        //alert(server.nombre);
         

        
        
        error: function(e)
        {
  console.log(e);         
              //console.log(e);
        }
     });
    }

    function acceder() {
      let usuario = document.getElementById("usuario").value
      let contrasena = document.getElementById("contrasena").value
    console.log(usuario);
    if (usuario !="" && contrasena !="") {
      $.ajax(
        {
            type: "POST",
            dataType:"JSON",
            url: "./GET/?source1=eventos&source2=getlogin",
            data: {"usuario":usuario, "contra":contrasena}, 
            beforeSend: function(event)
            {
            },
            success: function(server)
            {
              if (server.estatus=='ok') {
                alert(window.location.href="eventos.html");  
              }
              else{
                Swal.fire({
                  icon: 'error',
                  title: 'Error al iniciar sesión',
                  
                  
                })
              }
              //alert(server.nombre);          
            },
            error: function(e)
            {
      console.log(e);         
                  //console.log(e);
            }
         });
    }else{
      Swal.fire({
        icon: 'error',
        title: 'Llena los campos',
        
        
      })
    }
  
    }


    function registrarSeguimiento() {
      let nombre = document.getElementById("nombre").value
      let correo = document.getElementById("correo").value
      let contrasena = document.getElementById("contrasena").value
    console.log(nombre);
    if (nombre !="" && correo !="" && contrasena !="") {
      $.ajax(
        {
            type: "POST",
            dataType: "JSON",
            url: "./POST/?source1=eventos&source2=setusuario",
            data: {"nombre":nombre, "correo":correo, "contrasena":contrasena}, 
            beforeSend: function(event)
            {
            },
            success: function(server)
            {
              if (server.estatus=='ok') {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Usuario registrado',
                  showConfirmButton: false,
                  timer: 1900
                });
              }          
            },
            error: function(e)
            {
      console.log(e);
               
                  //console.log(e);
            }
         });
    }else{
      Swal.fire({
        icon: 'error',
        title: 'Llena los campos',
        
        
      })
    }
  
    }

    
    function restablecer() {
      let contrasena = document.getElementById("contrasena").value
      let contranueva = document.getElementById("contranueva").value
    console.log(contrasena);
    if (contrasena !="" && contranueva !="") {
      $.ajax(
        {
            type: "POST",
            dataType: "JSON",
            url: "./POST/?source1=eventos&source2=updcontrasena",
            data: {"usuario":contrasena, "contra":contranueva}, 
            beforeSend: function(event)
            {
            },
            success: function(server)
            {
            if (server.estatus=='ok'){
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Contraseña restablecida',
                showConfirmButton: false,
                timer: 1900
              });
            } else{
              Swal.fire({
        icon: 'error',
        title: 'Datos incorrectos',
        
        
      })
            }         
            },
            error: function(e)
            {
      console.log(e);
               
                  //console.log(e);
            }
         });
    }
    else{
      Swal.fire({
        icon: 'error',
        title: 'Llena los campos',
        
        
      })      
    }
  
    }
    