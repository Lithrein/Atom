<?php
/*****************************************************************************************
**  Copyright (c) 2010 Lithrein                                                         **
**                                                                                      **
**  Permission  is hereby granted, free of charge, to any person obtaining a copy of    **
**  this  software  and  associated documentation files (the "Software"), to deal in    **
**  the  Software  without  restriction,  including without limitation the rights to    **
**  use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of    **
**  the  Software, and to permit persons to whom the Software is furnished to do so,    **
**  subject to the following conditions:                                                **
**                                                                                      **
**  The  above  copyright notice and this permission notice shall be included in all    **
**  copies or substantial portions of the Software.                                     **
**                                                                                      **
**  THE  SOFTWARE  IS  PROVIDED  "AS  IS",  WITHOUT WARRANTY OF ANY KIND, EXPRESS OR    **
**  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS    **
**  FOR  A  PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR    **
**  COPYRIGHT  HOLDERS  BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER    **
**  IN  AN  ACTION  OF  CONTRACT,  TORT  OR  OTHERWISE,  ARISING  FROM, OUT OF OR IN    **
**  CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.          **
******************************************************************************************/

class Atom_Feed {
     /**
      * \brief Stream file's path
      * \since 1.0
      * 
      * @var string
      * @name path
      */
    private $path;
     /**
      * \brief Title of Atom Feed
      * \since 1.0
      * 
      * @var string
      * @name title
      */
    private $title;
     /**
      * \brief Stream's author 
      * \since 1.0
      *
      * @var string
      * @name author
      */
    private $author;
     /**
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
     /**
      * \brief Identificator's entry (mandatory)
      * \since 1.0
      *
      * @var string
      * @name id
      */
    private $id;
     /**
      * \brief The entry is entitled `title' (mandatory)
      * \since 1.0
      *
      * @var Atom_Text (title)
      * @name title
      */
    private $title;
     /**
      * \brief timestamp of the last update (mandatory)
      * \since 1.0
      *
      * @var int
      * @name date
      */
    private $date;
     /**
      * \brief The author(s)
      * \since 1.0
      *
      * @var Atom_Person[]
      * @name author
      */
    private $author;
     /**
      * \brief The content
      * \since 1.0
      *
      * @var Atom_Text (content)
      * @name content
      */
    private $content;
     /**
      * \brief Link(s)
      * \since 1.0
      *
      * @var Atom_Link[]
      * @name links
      */
    private $links;
     /**
      * \brief A summary about the content
      * \since 1.0
      *
      * @var Atom_Text
      * @name summary
      */
    private $summary;
     /**
      * \brief Category(ies) of the contents
      * \since 1.0
      *
      * @var Atom_Category[]
      * @name Atom_Category
      */
    private $category;
     /**
      * \brief list of contributors
      * \since 1.0
      *
      * @var Atom_Person[]
      * @name contributors
      */
    private $contributors;
     /**
      * \brief Copyright
      * \since 1.0
      *
      * @var Atom_Text (rights)
      * @name rights
      */
    private $rights;

     /**
      * \brief Constructor of Atom_Entry
      * \since 1.0
      *
      * @param $id           : string
      * @param $title        : string
      * @param $date         : int (timestamp)
      * @param $author       : Atom_Person[]
      * @param $content      : Atom_Text
      * @param $links        : Atom_Link[]
      * @param $summary      : Atom_Text
      * @param $category     : Atom_Category[]
      * @param $contributors : Atom_Person[]
      * @param $rigths       : Atom_Text
      */
    public function __construct ( $id, $title, $date, $author = null, $content = null, $links = null, $summary = null, $category = null, $contributors = null, $rights = null ) {
         /* Mandatory  */
        $this->id = (string) $id;
        $this->title = (string) $title;
        $this->date = date('c', (int) $date)
         /* Others  */
        $this->author = (empty($author)) ? array() : $author;
        $this->content = (empty($content)) ? null : $content;
        $this->links = (empty($links)) ? array() : $links;
        $this->summary = (empty($summary)) ? null : $summary;
        $this->category = (empty($category)) ? array() : $category;
        $this->contributors = (empty($contributors)) ? array() : $contributors;
        $this->rights = (empty($rights)) ? null : $rights;
    }

     /**
      * \brief Getter of $id
      * \since 1.0
      *
      * @return $id : string
      */
    public function get_id () {
        return $this->id;
    }

     /**
      * \brief Getter of $title
      * \since 1.0
      *
      * @return $title : Atom_Text
      */
    public function get_title () {
        return $this->title;
    }
    
     /**
      * \brief Getter of $date
      * \since 1.0
      *
      * @return $date : int
      */
    public function get_date () {
        return $this->date;
    }
    
     /**
      * \brief Getter of $author
      * \since 1.0
      *
      * @return $author : Atom_Person[]
      */
    public function get_author () {
        return $this->author;
    }
    
     /**
      * \brief Getter of $content
      * \since 1.0
      *
      * @return $content : Atom_Text
      */
    public function get_content () {
        return $this->content;
    }
    
     /**
      * \brief Getter of $links
      * \since 1.0
      *
      * @return $links : Atom_Link[]
      */
    public function get_links () {
        return $this->links;
    }
    
     /**
      * \brief Getter of $summary
      * \since 1.0
      *
      * @return $summary : Atom_Text
      */
    public function get_summary () {
        return $this->summary;
    }
    
     /**
      * \brief Getter of $category
      * \since 1.0
      *
      * @return $category : Atom_Category
      */
    public function get_category () {
        return $this->category;
    }
    
     /**
      * \brief Getter of $contributors
      * \since 1.0
      *
      * @return $contributors : Atom_Person[]
      */
    public function get_contributors () {
        return $this->contributors;
    }
    
     /**
      * \brief Getter of $rigths
      * \since 1.0
      *
      * @return $rigths : Atom_Text
      */
    public function get_rigths () {
        return $this->rigths;
    }

     /**
      * \brief Setter of $id
      * \since 1.0
      *
      * @param $id : string
      * @return $this : Atom_Category
      */
    public function id( $id ) {
        $this->id = (string) $id;
        return $this;
    }

     /**
      * \brief Setter of $title
      * \since 1.0
      *
      * @param $title : string
      * @return $this : Atom_Category
      */
    public function title( $title ) {
        $this->title = (string) $title;
        return $this;
    }

     /**
      * \brief Setter of $date
      * \since 1.0
      *
      * @param $date : string
      * @return $this : Atom_Category
      */
    public function date( $date ) {
        $this->date = (string) $date;
        return $this;
    }

     /**
      * \brief Setter of $author
      * \since 1.0
      *
      * @param $author : string
      * @return $this : Atom_Category
      */
    public function author( $author ) {
        $this->author = (string) $author;
        return $this;
    }

     /**
      * \brief Setter of $content
      * \since 1.0
      *
      * @param $content : string
      * @return $this : Atom_Category
      */
    public function content( $content ) {
        $this->content = (string) $content;
        return $this;
    }

     /**
      * \brief Setter of $links
      * \since 1.0
      *
      * @param $links : string
      * @return $this : Atom_Category
      */
    public function links( $links ) {
        $this->links = (string) $links;
        return $this;
    }

     /**
      * \brief Setter of $summary
      * \since 1.0
      *
      * @param $summary : string
      * @return $this : Atom_Category
      */
    public function summary( $summary ) {
        $this->summary = (string) $summary;
        return $this;
    }

     /**
      * \brief Setter of $category
      * \since 1.0
      *
      * @param $category : string
      * @return $this : Atom_Category
      */
    public function category( $category ) {
        $this->category = (string) $category;
        return $this;
    }

     /**
      * \brief Setter of $contributors
      * \since 1.0
      *
      * @param $contributors : string
      * @return $this : Atom_Category
      */
    public function contributors( $contributors ) {
        $this->contributors = (string) $contributors;
        return $this;
    }

     /**
      * \brief Setter of $rigths
      * \since 1.0
      *
      * @param $rigths : string
      * @return $this : Atom_Category
      */
    public function rigths( $rigths ) {
        $this->rigths = (string) $rigths;
        return $this;
    }
}

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
    public function __construct ( $name, $scheme = '', $label = '' ) {
        
        $this->name   = (string) $name;
        $this->scheme = (string) $scheme;
        $this->label  = (string) $label;

    }

     /**
      * \brief Generates the xml of the Atom_Category entry
      * \since 1.0
      *
      * @return DomDocument
      */
    public function generate_xml () {
        $doc = new DomDocument;
        $cat = $doc->createElement('catgory');
        $category = $doc->appendChild($cat);
        
        $category->setAttribute ("name", (string) $this->name);
        if (!empty($this->scheme))
            $category->setAttribute ("scheme", (string) $this->scheme);
        if (!empty($this->label))
            $category->setAttribute ("label", (string) $this->label);
        

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
      * \brief Content tag (title, summary, content, rights)
      * \since 1.0
      *
      * @var string
      * @name tag
      */
    private $tag;
     /**
      * \brief Kind of content (text, html, xhtml)
      * \since 1.0
      *
      * @var string
      * @name type
      */
    private $type;
     /**
      * \brief Text in the node tag
      * \since 1.0
      *
      * @var string
      * @name content
      */
    private $content;
     /**
      * \brief Charset to encode plain text
      * \since 1.0
      *
      * @var string
      * @name charset
      */
    private $charset;

     /**
      * \brief Text construction's constructor
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

    /**
     * \brief Generates the xml of the Atom_Text entry
     *
     * @return $doc : DomDocument
     */
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
        return $doc;
    }

     /**
      * \brief Getter of tag
      * \since 1.0
      *
      * @return $tag : string
      */
    public function get_tag () {
        return $this->tag;
    }

     /**
      * \brief Getter of type
      * \since 1.0
      *
      * @return $type : string
      */
    public function get_type () {
        return $this->type;
    }

     /**
      * \brief Getter of content
      * \since 1.0
      *
      * @return $content : string
      */
    public function get_content () {
        return $this->content;
    }

     /**
      * \brief Getter of charset
      * \since 1.0
      *
      * @return $charset : string
      */
    public function get_charset () {
        return $this->charset;
    }

    /**
     * \brief Setter of tag
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
     * \brief Setter of type
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
     * \brief Setter of content
     * \since 1.0
     *
     * @param $content : string
     * @return $this   : Atom_Text
     */
    public function content ( $content ) {
        $this->content = (string) $content;
        return $this;
    }
    
    /**
     * \brief Setter of charset
     *
     * @param $charset : string
     * @return $this   : Atom_Text
     */
    public function charset ( $charset ) {
        $this->charset = (string) $charset;
        return $this;
    }
}

class Atom_Link {
     /**
      * \brief Hypertext reference of the link
      * \since 1.0
      *
      * @var string
      * @name href
      */
    private $href;
     /**
      * \brief Link's relation with the stream
      * \since 1.0
      *
      * @var string
      * @name rel
      */
    private $rel;
     /**
      * \brief type of content
      * \since 1.0
      *
      * @var string
      * @name type
      */
    private $type;
     /**
      * \brief Website's language pointed to by the URL
      * \since 1.0
      *
      * @var string
      * @name hreflang
      */
    private $hreflang;
     /**
      * \brief Weight of the page pointed to by the URL (bytes)
      * \since 1.0
      *
      * @var string
      * @name int
      */
    private $length;
    
     /**
      * \brief Link construction's constructor
      * \todo improve security and verification
      * \since 1.0
      *
      * @param $href     : string
      * @param $rel      : string
      * @param $type     : string
      * @param $herflang : string
      * @param $length   : int
      */
    public function __construct ( $href, $rel = '', $type = '', $hreflang = '', $length = 0) {
        $this->href     = (string) $href;
        $this->rel      = (string) $rel;
        $this->type     = (string) $type;
        $this->hreflang = (string) $hreflang;
        $this->length   = (int) $length;
    }
    
    /**
     * \brief Generates the xml of the Atom_Link entry
     *
     * @return $doc : DomDocument
     */
    public function generate_xml () {
        $doc = new DomDocument;
        $link = $doc->createElement('link');
        $link_node = $doc->appendChild($link);
        
        $link_node->setAttribute ("href", (string) $this->href);
        if (!empty($this->rel))
            $link_node->setAttribute ("rel",  (string) $this->rel);
        if (!empty($this->type))
            $link_node->setAttribute ("type",  (string) $this->type);
        if (!empty($this->hreflang))
            $link_node->setAttribute ("hreflang", (string) $this->hreflang);
        if (!empty($this->length))
            $link_node->setAttribute ("length", (int) $this->length);
            
        return $doc;
    }
    
     /**
      * \brief Getter of href
      * \since 1.0
      *
      * @return $href : string
      */
    public function get_href () {
        return $this->href;
    }
    
     /**
      * \brief Getter of rel
      * \since 1.0
      *
      * @return $rel : string
      */
    public function get_rel () {
        return $this->rel;
    }
    
     /**
      * \brief Getter of type
      * \since 1.0
      *
      * @return $type : string
      */
    public function get_type () {
        return $this->type;
    }
    
     /**
      * \brief Getter of hreflang
      * \since 1.0
      *
      * @return $hreflang : string
      */
    public function get_hreflang () {
        return $this->hreflang;
    }
    
     /**
      * \brief Getter of length
      * \since 1.0
      *
      * @return $length : int
      */
    public function get_length () {
        return $this->length;
    }

     /**
     * \brief Setter of href
     * \since 1.0
     *
     * @param $href   : string
     * @return $this  : Atom_Link
     */
    public function href ( $href ) {
        $this->href = (string) $href;
        return $this;
    }
    
     /**
     * \brief Setter of rel
     * \since 1.0
     *
     * @param $rel   : string
     * @return $this : Atom_Link
     */
    public function rel  ( $rel ) {
        $this->rel = (string) $rel;
        return $this;
    }
    
     /**
     * \brief Setter of type
     * \since 1.0
     *
     * @param $type   : string
     * @return $this  : Atom_Link
     */
    public function type ( $type ) {
        $this->type = (string) $type;
        return $this;
    }
    
     /**
     * \brief Setter of hreflang
     * \since 1.0
     *
     * @param $hreflang   : string
     * @return $this      : Atom_Link
     */
    public function hreflang ( $hreflang ) {
        $this->hreflang = (string) $hreflang;
        return $this;
    }
    
    
     /**
     * \brief Setter of length
     * \since 1.0
     *
     * @param $length   : int
     * @return $this    : Atom_Link
     */
    public function length ( $length ) {
        $this->length = (int) $length;
        return $this;
    }
}

class Atom_Person {
     /**
      * \brief Name of the author
      * \since 1.0
      *
      * @var string
      * @name name
      */
    private $name;
    /**
      * \brief URI (Uniform Ressource Indicator) of the author (e.g.: His Website)
      * \since 1.0
      *
      * @var string
      * @name uri
      */
    private $uri;
    /**
      * \brief E-mail adress of the author
      * \since 1.0
      *
      * @var string
      * @name mail
      */
    private $mail;

     /**
      * \brief Atom_Person construction's constructor
      *
      * @param $name : string
      * @param $uri  : string
      * @param $mail : string
      */
    public function __construct ( $name, $uri = '', $mail = '' ) {
       $this->name = (string) $name;
       $this->uri  = (string) $uri;
       $this->mail = (string) $mail;
    }
    
    /**
     * \brief Generates the xml of the Atom_Person entry
     *
     * @return $doc : DomDocument
     */
    public function generate_xml () {
        $doc = new DomDocument;
        $_tag = $doc->createElement("author");
        $tag = $doc->appendChild($_tag);

        $name = $doc->createElement("name");
        $_name = $doc->createTextNode((string )$this->name);
        $name->appendChild($_name);
        $tag->appendChild($name);

        if (!empty($this->uri)) {
            $uri = $doc->createElement("uri");
            $_uri = $doc->createTextNode((string )$this->uri);
            $uri->appendChild($_uri);
            $tag->appendChild($uri);
        }
        
        if (!empty($this->mail)) {
            $mail = $doc->createElement("mail");
            $_mail = $doc->createTextNode((string) $this->mail);
            $mail->appendChild($_mail);
            $tag->appendChild($mail);
        }
        
        return $doc;
    }

     /**
      * \brief Getter of name
      * \since 1.0
      *
      * @return $name : string
      */
    public function get_name () {
        return $this->name;
    }

     /**
      * \brief Getter of uri
      * \since 1.0
      *
      * @return $uri : string
      */
    public function get_uri () {
        return $this->uri;
    }

     /**
      * \brief Getter of mail
      * \since 1.0
      *
      * @return $mail : string
      */
    public function get_mail () {
        return $this->mail;
    }

    /**
     * \brief Setter of name
     * \since 1.0
     *
     * @param $name   : string
     * @return $this  : Atom_Person
     */
    public function name ( $name) {
        $this->name = (string) $name;
        return $this;
    }

    /**
     * \brief Setter of uri
     * \since 1.0
     *
     * @param $uri   : string
     * @return $this : Atom_Person
     */
    public function uri ( $uri ) {
        $this->uri = (string) $uri;
        return $this;
    }

    /**
     * \brief Setter of mail
     * \since 1.0
     *
     * @param $mail    : string
     * @return $this   : Atom_Person
     */
    public function mail ( $mail ) {
        $this->mail = (string) $mail;
        return $this;
    }
}
