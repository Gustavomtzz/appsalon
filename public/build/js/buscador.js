function eventListeners(){fechaSeleccionada()}function fechaSeleccionada(){document.querySelector("#fecha").addEventListener("change",e=>{fechaSeleccionada=e.target.value,window.location="?fecha="+fechaSeleccionada})}function confirmDelete(e){console.log(e),e.preventDefault(),Swal.fire({title:"Confirmación",text:"¿Estás seguro de que deseas eliminar este registro/cita?",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Sí, eliminar",cancelButtonText:"Cancelar",padding:"4rem"}).then(e=>{e.isConfirmed&&document.querySelector("#formEliminarCita").submit()})}document.addEventListener("DOMContentLoaded",(function(){eventListeners()}));