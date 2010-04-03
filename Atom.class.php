<?php

class Atom_Feed {

     /**
      * \brief Stream file's path
      * \since 1.0
      * 
      * @var string
      * @name path
      */
    private $path = "";
     /**
      * \brief Title of Atom Feed
      * \since 1.0
      * 
      * @var string
      * @name title
      */
    private $title = "";
     /**
      * \brief Stream's author 
      * \since 1.0
      *
      * @var string
      * @name author
      */
    private $author = "";
     /*
      * \brief Dom Document (Atom Feed)
      * \since 1.0
      * 
      * @var DOMDocument
      * @name document
      */
    private $document;
     /**
      * \brief Atom Feed's Logo (Path)
      * \since 1.0
      *
      * @var string
      * @name logo
      */
    private $logo;
     /**
      * \brief Atom Feed's icon (Path)
      * \since 1.0
      *
      * @var string
      * @name icon
      */
    private $icon;
      
     /**
      * \brief Constructor of Atom_Feed
      * \since 1.0
      *
      * @param $path  : string
      * @param $title : string
      * @param author : string
      */
    public function __construct ( $path, $title, $author ) {
        
        $this->path   = (string) $path;
        $this->title  = (string) $title;
        $this->author = (string) $author;
    }
    
     /**
      * \brief Adding an entry to the feed
      * \since 1.0
      *
      * @param $entry : Atom_Entry
      */
    public function addEntry ( $entry ) {
    }

}

class Atom_Entry {

}

/************************
 ** Atom Construction **
************************/

class Atom_Category {
    
     /**
      * \brief Category's name
      * \since 1.0
      *
      * @var string
      * @name name
      */
    private $name;
     /**
      * \brief Categorization scheme
      * \since 1.0
      *
      * @var string
      * @name scheme
      */
    private $scheme;
     /**
      * \brief Title of Category
      * \since 1.0
      * 
      * @var string
      * @name label
      */
    private $label;

     /**
      * \brief Constructor of Atom_Category
      * \since 1.0
      *
      * @param $name   : string
      * @param $scheme : string
      * @param $label  : string
      */
    public function __construct ( $name, $scheme, $label ) {
        
        $this->name   = (string) $name;
        $this->scheme = (string) $scheme;
        $this->label  = (string) $label;

    }

     /**
      * \brief Generate the xml of the category
      * \since 1.0
      *
      * @return DomElement
      */
    public function generate_xml () {
        $doc = new DomDocument;
        $cat = $doc->createElement('catgory');
        $category = $doc->appendChild($cat);
        
        $category->setAttribute ("name",   (string) $this->name );
        $category->setAttribute ("scheme", (string) $this->scheme);
        $category->setAttribute ("label",  (string) $this->label  );

        return $doc->saveXML();
    }
    
     /**
      * \brief Getter of $name
      * \since 1.0
      *
      * @return $name : int
      */
    public function get_name () {
        return $this->name;
    }

     /**
      * \brief Getter of $scheme
      * \since 1.0
      *
      * @return $scheme : int
      */
    public function get_scheme () {
        return $this->scheme;
    }

     /**
      * \brief Getter of $label
      * \since 1.0
      *
      * @return $label : int
      */
    public function get_label () {
        return $this->label;
    }
    
     /**
      * \brief Setter of $name
      * \since 1.0
      *
      * @param $name : string
      * @return $this : Atom_Category
      */
    public function name( $name ) {
        $this->name = (string) $name;
        return $this;
    }

     /**
      * \brief Setter of $scheme
      * \since 1.0
      *
      * @param $scheme : string
      * @return $this : Atom_Category
      */
    public function scheme( $scheme ) {
        $this->scheme = (string) $scheme;
        return $this;
    }

     /**
      * \brief Setter of $label
      * \since 1.0
      *
      * @param $label : string
      * @return $this : Atom_Category
      */
    public function label ( $label ) {
        $this->label = (string) $label;
        return $this;
    }
}

class Atom_Text {
}

?>

