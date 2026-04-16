<?php 
$isEdit = isset($emisora) && $emisora !== null;
$actionUrl = $isEdit ? url("/emisoras/editar/" . $emisora->id()->value()) : url("/emisoras/crear");
$btnText = $isEdit ? "Actualizar Emisora" : "Guardar Emisora";
ob_start(); 
?>

<div class="mb-6">
    <a href="<?= url('/emisoras') ?>" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">← Volver a la lista</a>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8 max-w-4xl mx-auto">
    <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            <?= $isEdit ? 'Editar Emisora' : 'Registrar Nueva Emisora' ?>
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Complete los detalles de la estación de radio.
        </p>
    </div>
    
    <div class="px-4 py-5 sm:p-6">
        <form action="<?= $actionUrl ?>" method="POST" class="space-y-6">
            
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                
                <div class="sm:col-span-3">
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la Emisora <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="nombre" id="nombre" required
                            value="<?= $isEdit ? htmlspecialchars($emisora->nombre()) : '' ?>"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md border p-2">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="canal" class="block text-sm font-medium text-gray-700">Canal <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="number" name="canal" id="canal" min="1" required
                            value="<?= $isEdit ? $emisora->canal() : '' ?>"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md border p-2">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="bandaFm" class="block text-sm font-medium text-gray-700">Frecuencia FM (ej. 88.5)</label>
                    <div class="mt-1">
                        <input type="text" name="bandaFm" id="bandaFm" placeholder="Opcional"
                            value="<?= $isEdit ? htmlspecialchars($emisora->bandaFm()->value() ?? '') : '' ?>"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md border p-2">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="bandaAm" class="block text-sm font-medium text-gray-700">Frecuencia AM (ej. 1040)</label>
                    <div class="mt-1">
                        <input type="text" name="bandaAm" id="bandaAm" placeholder="Opcional"
                            value="<?= $isEdit ? htmlspecialchars($emisora->bandaAm()->value() ?? '') : '' ?>"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md border p-2">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="numLocutores" class="block text-sm font-medium text-gray-700">No. Locutores <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="number" name="numLocutores" id="numLocutores" min="0" required
                            value="<?= $isEdit ? $emisora->numLocutores() : '0' ?>"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md border p-2">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="numProgramas" class="block text-sm font-medium text-gray-700">No. Programas <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="number" name="numProgramas" id="numProgramas" min="0" required
                            value="<?= $isEdit ? $emisora->numProgramas() : '0' ?>"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md border p-2">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="numCiudades" class="block text-sm font-medium text-gray-700">No. Ciudades <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="number" name="numCiudades" id="numCiudades" min="0" required
                            value="<?= $isEdit ? $emisora->numCiudades() : '0' ?>"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md border p-2">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="genero" class="block text-sm font-medium text-gray-700">Género <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="genero" id="genero" required placeholder="Noticias, Pop, Rock..."
                            value="<?= $isEdit ? htmlspecialchars($emisora->genero()) : '' ?>"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md border p-2">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="pais" class="block text-sm font-medium text-gray-700">País <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="pais" id="pais" required
                            value="<?= $isEdit ? htmlspecialchars($emisora->pais()) : '' ?>"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md border p-2">
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="horario" class="block text-sm font-medium text-gray-700">Horario <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="horario" id="horario" required placeholder="Lunes a Viernes de 6am a 10pm"
                            value="<?= $isEdit ? htmlspecialchars($emisora->horario()) : '' ?>"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md border p-2">
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="patrocinador" class="block text-sm font-medium text-gray-700">Patrocinador Principal</label>
                    <div class="mt-1">
                        <input type="text" name="patrocinador" id="patrocinador"
                            value="<?= $isEdit ? htmlspecialchars($emisora->patrocinador() ?? '') : '' ?>"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md border p-2">
                    </div>
                </div>

                <div class="sm:col-span-6">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <div class="mt-1">
                        <textarea id="descripcion" name="descripcion" rows="3" 
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2"><?= $isEdit ? htmlspecialchars($emisora->descripcion() ?? '') : '' ?></textarea>
                    </div>
                </div>

            </div>

            <div class="pt-5 border-t border-gray-200 flex justify-end">
                <a href="<?= url('/emisoras') ?>" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <?= $btnText ?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php'; 
