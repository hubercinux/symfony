<?php

namespace Miweb\MiwebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//para validar
use Symfony\Component\Validator\Constraints as Assert;
//para subir imagenes
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Categoria
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Miweb\MiwebBundle\Entity\CategoriaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Categoria
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

     /**
     * @var date
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
    * @ORM\OneToMany(targetEntity="Producto", mappedBy="categoria")
    */
    private $producto;

    public function __construct()
    {
        //$this->products = new ArrayCollection();  //---> Con esto me salia el error
        $this->producto = new \Doctrine\Common\Collections\ArrayCollection(); // con este no
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Categoria
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add producto
     *
     * @param \Miweb\MiwebBundle\Entity\Producto $producto
     * @return Categoria
     */
    public function addProducto(\Miweb\MiwebBundle\Entity\Producto $producto)
    {
        $this->producto[] = $producto;
    
        return $this;
    }

    /**
     * Remove producto
     *
     * @param \Miweb\MiwebBundle\Entity\Producto $producto
     */
    public function removeProducto(\Miweb\MiwebBundle\Entity\Producto $producto)
    {
        $this->producto->removeElement($producto);
    }

    /**
     * Get producto
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducto()
    {
        return $this->producto;
    }

    public function __toString()
    {
        //return strval($this->id);
       return $this->getNombre();
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Categoria
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }





    //a aqui hacia abajo es para subir imagen

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;


    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // la ruta absoluta del directorio donde se deben
        // guardar los archivos cargados
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
        //return __DIR__.'/web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // se deshace del __DIR__ para no meter la pata
        // al mostrar el documento/imagen cargada en la vista.
        return 'uploads/img_categoria';
    }









    private $temp;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;


    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            //$this->path = 'initial';
            //$this->path = 'initial'.$this->getFile()->guessExtension();
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->getFile()->guessExtension();
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // haz lo que quieras para generar un nombre único
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->getFile()->guessExtension();
        }

    }


    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // la propiedad img puede estar vacía si el campo no es obligatorio
        if (null === $this->getFile()) {
            return;
        }



        //Verificar la extension para guardar la imagen, aun no fucina aqui
        $extension = $this->getFile()->guessExtension();
                    
        $extvalidas = array('JPG','JPEG','PNG','GIF');
                    
        if ( !in_array(strtoupper($extension), $extvalidas)){
            return ;
        }


        // aquí usa el nombre de archivo original pero lo debes
        // sanear al menos para evitar cualquier problema de seguridad

        // lo mueve tomando el directorio destino y luego
        // el nombre de archivo al cual moverlo
        //$this->file->move($this->getUploadRootDir(),$this->getFile()->getClientOriginalName());

        // configura la propiedad 'path' al nombre de archivo en que lo guardaste

        //$this->path = $this->file->getClientOriginalName();

        // limpia la propiedad «file» ya que no la necesitas más
        //$this->img = null;


        //esto es con retrollamadas---------------------------------------

        // si hay un error al mover el archivo, move() automáticamente
        // envía una excepción. This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;

    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

}