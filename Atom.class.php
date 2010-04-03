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
      * @param $path   : string
      * @param $title  : string
      * @param $author : string
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
      * @return DomDocument
      */
    public function generate_xml () {
        $doc = new DomDocument;
        $cat = $doc->createElement('catgory');
        $category = $doc->appendChild($cat);
        
        $category->setAttribute ("name",   (string) $this->name);
        $category->setAttribute ("scheme", (string) $this->scheme);
        $category->setAttribute ("label",  (string) $this->label);

        return $doc;
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

     /**
      * \brief Balise de contenu (title, summary, content, rights)
      * \since 1.0
      *
      * @var string
      * @name tag
      */
    private $tag;
     /**
      * \brief Type de contenu (text, html, xhtml)
      * \since 1.0
      *
      * @var string
      * @name type
      */
    private $type;
     /**
      * \brief Texte contenu dans la balise indiquée par tag
      * \since 1.0
      *
      * @var string
      * @name content
      */
    private $content;
     /**
      * \brief Charset pour l'encodage
      * \since 1.0
      *
      * @var string
      * @name charset
      */
    private $charset;

     /**
      * \brief Constructeur de la construction text
      * \since 1.0
      *
      * @param $tag     : string
      * @param $type    : string
      * @param $content : string
      */
    public function __construct ( $tag, $type, $content , $charset = "UTF-8") {

        $this->tag     = (string) $tag;
        $this->type    = (string) $type;
        $this->content = (string) $content;

    }

    public function generate_xml () {
        $doc = new DomDocument;
        $_tag = $doc->createElement($this->tag);
        $tag = $doc->appendChild($_tag);
        
        $tag->setAttribute("type", (string) $this->type);
        
        if (!strcmp($this->type, "html") || !strcmp($this->type, "xhtml")) {
            $content = htmlentities($this->content, ENT_NOQUOTES, $this->charset);

            if (!strcmp($this->type, "html")) {
                $texte = $doc->createTextNode($content);
                $tag->appendChild($texte);
            } else {
                $div = $doc->createElement("div");
                $div->setAttribute("xmlns", "http://www.w3.org/1999/xhtml");

                $texte = $doc->createTextNode($content);
                $div->appendChild($texte);
                $tag->appendChild($div);
            }

        } else {
            $texte = $doc->createTextNode($this->content);
            $tag->appendChild($texte);
        }
        return $doc
    }

     /**
      * \brief Getter de tag
      * \since 1.0
      *
      * @return $tag : string
      */
    public function get_tag () {
        return $this->tag;
    }

     /**
      * \brief Getter de type
      * \since 1.0
      *
      * @return $type : string
      */
    public function get_type () {
        return $this->type;
    }

     /**
      * \brief Getter de content
      * \since 1.0
      *
      * @return $content : string
      */
    public function get_content () {
        return $this->content;
    }

     /**
      * \brief Getter de charset
      * \since 1.0
      *
      * @return $charset : string
      */
    public function get_charset () {
        return $this->charset;
    }

    /**
     * \brief Setter de tag
     * \since 1.0
     *
     * @param $tag   : string
     * @return $this : Atom_Text
     */
    public function tag ( $tag ) {
        $this->tag = (string) $tag;
        return $this;
    }

    /**
     * \brief Setter de type
     * \since 1.0
     *
     * @param $type  : string
     * @return $this : Atom_Text
     */
    public function type ( $type ) {
        $this->type = (string) $type;
        return $this;
    }

    /**
     * \brief Setter de content
     * \since 1.0
     *
     * @param $content : string
     * @return $this   : Atom_Text
     */
    public function content ( $content ) {
        $this->content = (string) $content;
        return $this;
    }

    public function charset ( $charset ) {
        $this->charset = (string) $charset;
    }
}

?>

