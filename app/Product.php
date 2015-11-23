<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use App\Traits\ProductOptionsTrait;

use Illuminate\Database\Eloquent\Model;

class Product extends Formable
{
    use SluggableTrait, ProductOptionsTrait;

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];


    protected $table = 'products';

    protected $fillable = ['title', 'features', 'extras', 'options', 'hlutur', 'price', 'vnr', 'content', 'slug', 'category_id', 'images', 'translations', 'order', 'status', 'files'];

    public $translatable = [
        'title',
        'content',
    ];


    public $fillableExtras = [
        'protein' => 'Protein',
        'trans_fat' => 'Trans fat',
        'fat' => 'Fita',
        'calories' => 'Calories',
        'serving' => 'Amount per serving',
        'made_fresh_with' => 'Made fresh daily with',
    ];

    public function getFeatures()
    {
        $ret = [
            0 => [
                'file' => '',
                'text' => '',
            ],
            1 => [
                'file' => '',
                'text' => '',
            ],
            2 => [
                'file' => '',
                'text' => '',
            ],
        ];

        if(isset($this->features)) { 
            $features = explode("|", $this->features);

            foreach($features as $k => $feature) {
                $f = explode("#", $feature);

                $ret[$k]['file'] = array_key_exists(0, $f) ? $f[0] : '';
                $ret[$k]['text'] = array_key_exists(1, $f) ? $f[1] : '';
            }
        }

        return $ret;
    }

    public $ingredients = [
        'mixed-greens.jpg' => 'BLANDAÐ GRÆNMETI',
        'veggies.jpg' => 'GRÆNMETI',
        'romano.jpg' => 'ROMANO OSTUR',
        'spinach.jpg' => 'FERSKT SPÍNAT',
        'spaghetti.jpg' => 'SPAGHETTI NÚÐLUR',
        'ziti.jpg' => 'ZITI NÚÐLUR',
        'ingredients-sausage.jpg' => 'KRYDDUÐ ÍTÖLSK PYLSA',
        'ingredients-cheese.jpg' => '100% OSTUR',
        'garlic.jpg' => 'FERSKUR LAUKUR',
        'dough.jpg' => 'DEIG BÚIÐ TIL Á STAÐNUM',
        'cucumber.jpg' => 'FERSKAR GÚRKUR',
        'croutons.jpg' => 'HVÍTLAUKS BRAUÐKUBBAR',
        'bacon.jpg' => 'STÖKKT BEIKON',
        'meatballs.jpg' => 'ÍTALSKAR KJÖTBOLLUR',
        'mozzarella.jpg' => '100% MOZZARELLA',
        'mushroom.jpg' => 'ALVÖRU SVEPPUM',
        'pepperoni.jpg' => 'PEPPERONI',
        'sliced-tomatos.jpg' => 'ÚRVALS TÓMATSSÓSA',
    ];

    protected $modelName = 'Product';

    public function modelName() {
        return $this->modelName;
    }

    protected $pluralName = 'Vörur';

    public function pluralName() {
        return $this->pluralName;
    }

    public function fields() {
        return $this->fields;
    }

    public function listables() {
        return $this->listables;
    }
    
    private $fields = [
        [
            'title' => 'Titill',
            'type' => 'text',
            'name' => 'title'
        ],
        [
            'title' => 'Verð',
            'type' => 'text',
            'name' => 'price'
        ],
        [
            'title' => 'Vörunúmer',
            'type' => 'text',
            'name' => 'vnr'
        ],
        [
            'title' => 'Features',
            'type' => 'text',
            'name' => 'features'
        ],
        [
            'title' => 'Efni',
            'type' => 'textarea',
            'name' => 'content',
            'args' => [
                'ckeditor' => true
            ],
        ],
    ];

    private $listables = [
        'Titill' => 'title',
        'ID' => 'id',
        'Slug' => 'slug',
        'Verð' => 'price',
    ];

    public $disable_parent_listing = true;

    public $parent_key = 'category_id';


    public function category()
    {
        return $this->belongsTo(\App\Category::class);
    }

    public function getPriceFormattedAttribute()
    {
        return $this->formatPrice($this->price);
    }

    public function formatPrice($price)
    {
        return number_format($price, 0, ',', '.').' kr.';
    }

    public function getSiblings()
    {
        if($this->category_id > 0)
            return \App\Product::where('category_id', $this->category_id)->where('id', '!=', $this->id)->get();

        return false;
    }

    public function optionsArray($selected_options)
    {
        $opts = [];

        $options = $this->options()->get();

        if(!empty($selected_options)) {
            foreach($selected_options as $k => $v) {
                $opts[$options[$k]['text']] = $options[$k]['values'][$v]['text'];
            }
        }

        return $opts;
    }
}