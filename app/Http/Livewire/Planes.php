<?php

namespace App\Http\Livewire;

use App\Models\Plan;
use Livewire\Component;
use Livewire\WithPagination;

class Planes extends Component
{

    use WithPagination;
    public $modelId;
    public $modalFormVisible = false;
    public $modalComfirmDeleteVisible = false; 
    public $nombre_plan;
    public $fecha_finalizacion;
    public $description;
    
    
    /**
     * Validacion de reglas
     *
     * @return void
     */
    public function rules(){
        return [
            'nombre_plan' => 'required',
            'fecha_finalizacion' => 'required',
            'description' => 'required',
        ];
    }

    public function mount(){ 
        $this->resetPage();
    }

    /**
     * Creación de la funsión
     *
     * @return void
     */
    public function create(){ 
        
        $this->validate();
        Plan::create($this->modalData());
        $this -> modalFormVisible = false;
        $this -> resetVars();

    }
    
    /**
     * Función Listar planes.  
     *
     * @return void
     */
    public function read (){

        return Plan::paginate(5);
    }
    
    /**
     * Función actualizar planes. 
     *
     * @return void
     */
    public function update (){
        $this -> validate();
        Plan::find($this->modelId)->update($this->modalData());
        $this->modalFormVisible = false;
    }

    
    /**
     * Función eliminar plan
     *
     * @return void
     */
    public function delete(){
        Plan::destroy($this->modelId);
        $this -> modalComfirmDeleteVisible = false;
        $this-> resetPage();
    }
    
    /**
     * Show the modal form
     * of the created fuctio
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modalFormVisible = true;
    }
    
    /**
     * 
     * Muestra el formulario modal
     * en modo de actualización
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id){
        $this->resetValidation();
        $this->resetVars();
        $this->modelId = $id;
        $this->modalFormVisible = true;
        $this->loadModal();
    }

    public function deleteShowModal($id){ 
        $this ->modelId = $id;
        $this -> modalComfirmDeleteVisible = true;
    }
    
    /**
     * Carga los datos modales
     * de estos componentes.
     *
     * @return void
     */
    public function loadModal(){
        $data = Plan::find($this->modelId);
        $this->nombre_plan = $data->nombre_plan;
        $this->fecha_finalizacion = $data->fecha_finalizacion;
        $this->description = $data->description;
    }
        
    /**
     * Los modelos mapeados
     * en este componente.
     *
     * @return void
     */
    public function modalData()
    {
        return [
            'nombre_plan' => $this->nombre_plan,
            'fecha_finalizacion' => $this->fecha_finalizacion,
            'description' => $this->description,
        ];
    }
    
    /**
     * Cambia toda la variable 
     * a null
     *
     * @return void
     */
    public function resetVars(){
        
        $this->modelId = null;
        $this->nombre_plan = null;
        $this->fecha_finalizacion = null;
        $this->description=null;
    }

    /**
     * The livewire render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.planes', [
            'data' => $this->read(),
        ]);
    }
}
