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

/** @todo a charset support */
class Atom_Feed {
     /**
      * \brief id of the feed (unique)
      * \since 1.0
      * 
      * @var string
      * @name id
      */
    private $id;
     /**
      * \brief Feed file's path
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
      * @var Atom_Text
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
      * \brief Feed's author 
      * \since 1.0
      *
      * @var Atom_Person
      * @name author
      */
    private $author;
     /**
      * \brief Feed's charset
      * \since 1.0
      *
      * @var string
      * @name charset
      */
    private $charset;
     /**
      * \brief Array of the feed's entries
      * \since 1.0
      *
      * @var Atom_Entry
      * @name entries
      */
    private $entries;
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
      * @param $id      : string
      * @param $path    : string
      * @param $title   : Atom_Text
      * @param $date    : int (timestamp)
      * @param $author  : Atom_Person
      * @param $charset : string
      * @param $entries : Atom_Entry[]
      * @param $logo    : string
      * @param $icon    : string
      */
    public function __construct ( $id, $path, $title, $date, $author, $charset = 'utf-8', $entries = null, $logo = null, $icon = null ) {
        $this->id      = (string) $id;
        $this->path    = (string) $path;
        $this->title   = $title;
        $this->date    = (int) $date;
        $this->author  = $author;
        $this->charset = (string) $charset;
        $this->entries = (empty($entries)) ? array() : $entries;
        $this->logo    = (empty($logo))    ? null    : (string) $logo;
        $this->icon    = (empty($icon))    ? null    : (string) $icon;
    }
    
     /**
      * \brief Adds an entry to the feed
      * \since 1.0
      *
      * @param $entry : Atom_Entry
      * @return $this : Atom_Feed
      */
    public function add_entry ( $entry ) {
        if ($entry instanceof Atom_Entry)
            $this->entries[] = $entry;
        else
            trigger_error("'\$entry' is not an instance  of Atom_Entry", E_USER_ERROR);

        return $this;
    }
    
     /**
      * \brief Makes the link tag and returns it
      * \since 1.0
      *
      * @return string
      */
    public function get_linktag () {
        return '<link rel="alternate" type="application/atom+xml" title="'.$this->title->get_content().'" href="'.$this->path.'" />'."\n";
    }

     /**
      * \brief Generates the xml document of an Atom feed
      * \since 1.0
      *
      * @return DomDocument
      */
    public function generate_xml () {
        $this->document = new DomDocument('1.0', (string) $this->charset);
        $_feed = $this->document->createElement('feed');
        $feed = $this->document->appendChild($_feed);
        
        $feed->setAttribute ("xmlns", "http://www.w3.org/2005/Atom");

         /* Madatory informations about the feed */
        $id    = $this->document->createElement('id');
        $date  = $this->document->createElement('updated');
        $_id   = $this->document->createTextNode((string) $this->id);
        $_title = $this->title->generate_xml()->getElementsByTagName('title')->item(0);
        $_date = $this->document->createTextNode(date('c', $this->date));
        $id->appendChild($_id);
        $title = $this->document->importNode($_title, true);
        $date->appendChild($_date);
        $feed->appendChild($id);
        $feed->appendChild($title);
        $feed->appendChild($date);

         /* The special link self */
        $self = new Atom_Link($this->path, 'self');
        $__self = $self->generate_xml()->getElementsByTagName('link')->item(0);
        $_self = $this->document->importNode($__self, true);
        $feed->appendChild($_self);

         /* The logo */
        $logo  = $this->document->createElement('logo');
        $_logo = $this->document->createTextNode((string) $this->logo);
        $logo->appendChild($_logo);
        $feed->appendChild($logo);
        
         /* Entries */
        foreach ($this->entries as $entry) {
            $__entry = $entry->generate_xml()->getElementsByTagName('entry')->item(0);
            $_entry = $this->document->importNode($__entry, true);
            $feed->appendChild($_entry);
        }
        
        /* Saves the document in the file pointed by $this->path */
        $file = fopen($this->path, 'w+');
        fprintf($file, '%s', $this->document->saveXML());
        fclose($file);

        return $this->document;
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
      * \brief Getter of $path
      * \since 1.0
      *
      * @return $path : string
      */
    public function get_path () {
        return $this->path;
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
      * \brief Getter of $author
      * \since 1.0
      *
      * @return $author : Atom_Person
      */
    public function get_author () {
        return $this->author;
    }
    
     /**
      * \brief Getter of $entries
      * \since 1.0
      *
      * @return $entries : Atom_Entry[]
      */
    public function get_entries () {
        return $this->entries;
    }

     /**
      * \brief Getter of $document
      * \since 1.0
      *
      * @return $document : DomDocument
      */
    public function get_document () {
        return $this->document;
    }

     /**
      * \brief Getter of $logo
      * \since 1.0
      *
      * @return $logo : string
      */
    public function get_logo () {
        return $this->logo;
    }
    
     /**
      * \brief Getter of $icon
      * \since 1.0
      *
      * @return $icon : string
      */
    public function get_icon () {
        return $this->icon;
    }

     /**
      * \brief Setter of $id
      * \since 1.0
      *
      * @param $id    : string
      * @return $this : Atom_Feed
      */
    public function id( $id ) {
        $this->id = (string) $id;
        return $this;
    }
     /**
      * \brief Setter of $path
      * \since 1.0
      *
      * @param $path  : string
      * @return $this : Atom_Feed
      */
    public function path( $path ) {
        $this->path = (string) $path;
        return $this;
    }
     /**
      * \brief Setter of $title
      * \since 1.0
      *
      * @param $title : string
      * @return $this : Atom_Feed
      */
    public function title( $title ) {
        $this->title = (string) $title;
        return $this;
    }
     /**
      * \brief Setter of $author
      * \since 1.0
      *
      * @param $author : string
      * @return $this  : Atom_Feed
      */
    public function author( $author ) {
        $this->author = (string) $author;
        return $this;
    }
     /**
      * \brief Setter of $entries
      * \since 1.0
      *
      * @param $entries : string
      * @return $this   : Atom_Feed
      */
    public function entries( $entries ) {
        $this->entries = (string) $entries;
        return $this;
    }
     /**
      * \brief Setter of $document
      * \since 1.0
      *
      * @param $document : string
      * @return $this    : Atom_Feed
      */
    public function document( $document ) {
        $this->document = (string) $document;
        return $this;
    }
     /**
      * \brief Setter of $logo
      * \since 1.0
      *
      * @param $logo  : string
      * @return $this : Atom_Feed
      */
    public function logo( $logo ) {
        $this->logo = (string) $logo;
        return $this;
    }
     /**
      * \brief Setter of $icon
      * \since 1.0
      *
      * @param $icon  : string
      * @return $this : Atom_Feed
      */
    public function icon( $icon ) {
        $this->icon = (string) $icon;
        return $this;
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
      * @name authors
      */
    private $authors;
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
      * @param $authors       : Atom_Person[]
      * @param $content      : Atom_Text
      * @param $links        : Atom_Link[]
      * @param $summary      : Atom_Text
      * @param $category     : Atom_Category[]
      * @param $contributors : Atom_Person[]
      * @param $rigths       : Atom_Text
      */
    public function __construct ( $id, $title, $date, $authors = null, $content = null, $links = null, $summary = null, $category = null, $contributors = null, $rights = null ) {
         /* Mandatory */
        $this->id           = (string) $id;
        $this->title        = $title;
        $this->date         = (int) $date;
         /* Others */
        $this->authors       = (empty($authors))     ? array() : $authors;
        $this->content      = (empty($content))      ? null    : $content;
        $this->links        = (empty($links))        ? array() : $links;
        $this->summary      = (empty($summary))      ? null    : $summary;
        $this->category     = (empty($category))     ? array() : $category;
        $this->contributors = (empty($contributors)) ? array() : $contributors;
        $this->rights       = (empty($rights))       ? null    : $rights;
    }
    
     /**
      * \brief Generates the xml of the Atom_Entry
      * \since 1.0 
      *
      * @return DomDocument in case of success, false otherwise
      */
    public function generate_xml () {

         /* Is the entry valid ?  */
         /* If at the end of this function $valid = false then there is a problem with the feed */
        $valid = false;
        /* Mandatory fileds are filled ? */
        if (empty($this->id) || empty($this->title) || empty($this->date)) {
            trigger_error("One (or more) mandatory field(s) are missing !", E_USER_ERROR);
            return false;
        } else {
            $doc = new DomDocument;
            $_entry = $doc->createElement('entry');
            $entry = $doc->appendChild($_entry);
            
             /* Madatory informations about the feed */
            $id    = $doc->createElement('id');
            $date  = $doc->createElement('updated');
            $_id   = $doc->createTextNode((string) $this->id);
            $_title = $this->title->generate_xml()->getElementsByTagName('title')->item(0);
            $_date = $doc->createTextNode(date('c', $this->date));
            $id->appendChild($_id);
            $title = $doc->importNode($_title, true);
            $date->appendChild($_date);
            $entry->appendChild($id);
            $entry->appendChild($title);
            $entry->appendChild($date);
            
             /* Authors */
            foreach ($this->authors as $author) {
                $__author = $author->generate_xml()->getElementsByTagName('author')->item(0);
                $_author = $doc->importNode($__author, true);
                $entry->appendChild($_author);
            }

            /* Content */
            if (!empty($this->content)) {
                $valid = true; /* The entry has at least a content  */
                $_content = $this->content->generate_xml()->getElementsByTagName('content')->item(0);
                $content = $doc->importNode($_content, true);
                $entry->appendChild($content);
            }
            
             /* Links */
            foreach ($this->links as $link) {
                if (!strcmp($link->get_rel(), 'alternate'))
                    $valid = true;

                $__link = $link->generate_xml()->getElementsByTagName('link')->item(0);
                $_link = $doc->importNode($__link, true);
                $entry->appendChild($_link);
            }
            
             /* Summary */
            if(!empty($this->summary)) {
                $_summary = $this->summary->generate_xml()->getElementsByTagName('summary')->item(0);
                $summary = $doc->importNode($_summary, true);
                $entry->appendChild($summary);
            }

             /* Categories */
            foreach ($this->category as $category) {
                $__category = $category->generate_xml()->getElementsByTagName('category')->item(0);
                $_category = $doc->importNode($__category, true);
                $entry->appendChild($_category);
            }

             /* Contributors */
            foreach ($this->contributors as $contributor) {
                $__contributor = $contributor->generate_xml()->getElementsByTagName('contributor')->item(0);
                $_contributor = $doc->importNode($__contributor, true);
                $entry->appendChild($_contributor);
            }

             /* Rights */
            if(!empty($this->rights)) {
                $_rights = $this->rights->generate_xml()->getElementsByTagName('rights')->item(0);
                $rights = $doc->importNode($_rights, true);
                $entry->appendChild($rights);
            }
            
            if (!$valid) {
                trigger_error("Your feed is invalid either a content or an alternative link is missing.", E_USER_NOTICE);
            }

            return $doc;
        }
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
      * \brief Getter of $authors
      * \since 1.0
      *
      * @return $authors : Atom_Person[]
      */
    public function get_authors () {
        return $this->authors;
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
      * @param $id    : string
      * @return $this : Atom_Entry
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
      * @return $this : Atom_Entry
      */
    public function title( $title ) {
        $this->title = (string) $title;
        return $this;
    }

     /**
      * \brief Setter of $date
      * \since 1.0
      *
      * @param $date  : string
      * @return $this : Atom_Entry
      */
    public function date( $date ) {
        $this->date = (string) $date;
        return $this;
    }

     /**
      * \brief Setter of $authors
      * \since 1.0
      *
      * @param $authors : string
      * @return $this   : Atom_Entry
      */
    public function authors( $author ) {
        $this->authors = (string) $authors;
        return $this;
    }

     /**
      * \brief Setter of $content
      * \since 1.0
      *
      * @param $content : string
      * @return $this   : Atom_Entry
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
      * @return $this : Atom_Entry
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
      * @return $this : Atom_Entry
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
      * @return $this : Atom_Entry
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
      * @return $this : Atom_Entry
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
      * @return $this : Atom_Entry
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
    private $term;
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
      * @param $term   : string
      * @param $scheme : string
      * @param $label  : string
      */
    public function __construct ( $term, $scheme = '', $label = '' ) {
        
        $this->term   = (string) $term;
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
        $cat = $doc->createElement('category');
        $category = $doc->appendChild($cat);
        
        $category->setAttribute ("term", (string) $this->term);
        if (!empty($this->scheme))
            $category->setAttribute ("scheme", (string) $this->scheme);
        if (!empty($this->label))
            $category->setAttribute ("label", (string) $this->label);
        

        return $doc;
    }
    
     /**
      * \brief Getter of $term
      * \since 1.0
      *
      * @return $term : int
      */
    public function get_term () {
        return $this->term;
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
      * \brief Setter of $term
      * \since 1.0
      *
      * @param $term  : string
      * @return $this : Atom_Category
      */
    public function term( $term ) {
        $this->term = (string) $term;
        return $this;
    }

     /**
      * \brief Setter of $scheme
      * \since 1.0
      *
      * @param $scheme : string
      * @return $this  : Atom_Category
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
      * \brief Content tag (title, subtitle, summary, content, rights)
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
      * \brief Name of the author, contibutor
      * \since 1.0
      *
      * @var string
      * @name name
      */
    private $name;
     /**
      * \brief Is an author or a contributor ?
      * \since 1.0
      *
      * @var string
      * @name type
      */
    private $type;
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
      * @name email
      */
    private $email;

     /**
      * \brief Atom_Person construction's constructor
      *
      * @param $name  : string
      * @param $type  : string
      * @param $uri   : string
      * @param $email : string
      */
    public function __construct ( $name, $type = 'author', $uri = '', $email = '' ) {
       $this->name = (string) $name;
       $this->type = (string) $type;
       $this->uri  = (string) $uri;
       $this->email = (string) $email;
    }
    
    /**
     * \brief Generates the xml of the Atom_Person entry
     *
     * @return $doc : DomDocument
     */
    public function generate_xml () {
        $doc = new DomDocument;
        $_tag = $doc->createElement((string) $this->type);
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
        
        if (!empty($this->email)) {
            $email = $doc->createElement("email");
            $_email = $doc->createTextNode((string) $this->email);
            $email->appendChild($_email);
            $tag->appendChild($email);
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
      * \brief Getter of type
      * \since 1.0
      *
      * @return $type : string
      */
    public function get_type () {
        return $this->type;
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
      * \brief Getter of email
      * \since 1.0
      *
      * @return $email : string
      */
    public function get_email () {
        return $this->email;
    }

    /**
     * \brief Setter of name
     * \since 1.0
     *
     * @param $name   : string
     * @return $this  : Atom_Person
     */
    public function name ( $name ) {
        $this->name = (string) $name;
        return $this;
    }

    /**
     * \brief Setter of type
     * \since 1.0
     *
     * @param $type   : string
     * @return $this  : Atom_Person
     */
    public function type ( $type ) {
        $this->type = (string) $type;
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
     * \brief Setter of email
     * \since 1.0
     *
     * @param $email    : string
     * @return $this    : Atom_Person
     */
    public function email ( $email ) {
        $this->email = (string) $email;
        return $this;
    }
}
