 <!-- modal subir publicacion -->
<div class="modal fade" id="modal_img" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva publicación</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">

                    <form action="upload.php" method="post" enctype="multipart/form-data">
                      <label for="text">Descripción</label>
                      <input class="form-control mb-4" type="text" name="text">

                      <label for="img">Selecciona la imagen</label>
                      <input class="form-control" type="file" name="img" id="img" accept="image/*" required>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Publicar</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>


