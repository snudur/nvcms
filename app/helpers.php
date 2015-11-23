<?php


function shorten($string, $limit = 100, $suffix = '…')
{
    $string = trim($string);
    
    if (strlen($string) < $limit) {
        return $string;
    }

    return mb_substr($string, 0, $limit) . $suffix;
}

function shortenClean($string, $limit = 100, $suffix = '…')
{
    $string = trim(strip_tags($string));

    if (strlen($string) < $limit) {
        return $string;
    }

    return mb_substr($string, 0, $limit) . $suffix;
}

function shortenCmsClean($item, $limit = 100, $suffix = '…')
{
    $content = filterImages($item);

    $string = trim(strip_tags($content));

    if (strlen($string) < $limit) {
        return $string;
    }

    return mb_substr($string, 0, $limit) . $suffix;
}


function getContentById($id)
{
    $content = \App\Page::find($id);
    return $content;
}

function getContentBySlug($slug)
{
    $content = \App\Page::where('slug', $slug)->first();
    return $content;
}


function kalPrevPath($path) {
    $parts = array_filter(explode("/", $path));
    
    array_pop($parts);
    
    $str = "";

    foreach ($parts as $part) {
        $str .= $part.'/';
    }

    $str = rtrim($str, "/");

    return $str;
}



function crumbs() {
    $parts = array_filter(explode("/", \Request::path()));

    $crumbs = [];

    $prev = "";

    foreach($parts as $part) {

        foreach(config('formable.hlutir') as $hlutur) {
            $class = "\App\\".ucfirst($hlutur);
            $m = new $class;
            $item = $m->where('slug', $part)->first();
            
            if(!$item) continue;

            
            $prev = $prev.'/'.$item->slug;
            

            $crumbs[$item->slug] = [
                'title' => $item->title,
                'path'  => $prev,
            ];
        }
    }

    return $crumbs;   
}

function kalCrumbs($uri) {
    $breadcrumbs = new Creitive\Breadcrumbs\Breadcrumbs;
    $breadcrumbs->addCrumb('Heim', '/');
    $breadcrumbs->setDivider('');
    $breadcrumbs->setCssClasses('kal-crumbs');

    $parts = array_filter(explode("/", $uri));

    foreach($parts as $part) {
        foreach(config('formable.hlutir') as $hlutur) {
            $class = "\App\\".ucfirst($hlutur);
            $m = new $class;
            $item = $m->where('slug', $part)->first();
            if(!$item)continue;
            $breadcrumbs->addCrumb($item->title, $item->slug);
        }
    }

    echo $breadcrumbs->render();
}




function kalMenuFromSlug($slug, $with_parent = false) {
    $subs = App\Product::where('slug', $slug)->first()->getSubs();
    return kalMenu($subs);
}


function kalMenuFromLvl($lvl) {
    return kalMenu(false, $lvl);
}

function kalMenuExpanded() {
    return kalMenu();
}

function kalMenuExpandedAll() {
    return kalMenu([
        'expand_all' => true,
        'hidden' => false
    ]);
}


function kalMenuFrom($slug) {
    $pages = App\Page::where('slug', $slug)->first()->getSubs();
    return kalMenu(false, $pages, $lvl = 2);
}


function kalMenu($args = array(), $pages = false, $lvl = 1, &$menu = "", &$paths = array())
{
    if(isset($args['hidden']) && $args['hidden']) {
        if(!$pages) $pages = App\Page::where('accordion', 0)->where('parent_id', 0)->orderBy('order')->get();
    } else {
        if(!$pages) $pages = App\Page::where('accordion', 0)->where('parent_id', 0)->where('status', '>', 0)->orderBy('order')->get();
    }

    $menu .= "<ul>";

    foreach($pages as $page) {
        if ($page->slug[0] == '_') continue;

        if($lvl==1 && isset($args['topmenu']) && !$page->topmenu) continue;
        
        $className = "App\\".ucfirst($page->hlutur);
        $m = new $className;
        
        $_id = $page->id;

        if(strtolower(trim($page->modelName())) != strtolower(trim($page->hlutur))) {
            $_id = 0;
        }

        if(isset($args['hidden']) && $args['hidden']) {
            $subs = $m->where('accordion', 0)->where($m->parent_key, $_id)->orderBy('order')->get();
        } else {
            $subs = $m->where('accordion', 0)->where($m->parent_key, $_id)->where('status', '>', 0)->orderBy('order')->get();
        }

        $paths[] = $page->slug;
        $path = "/";

        $active = \Request::segment($lvl) == $page->slug ? 'active' : '';
        //echo $lvl.' '.$page->path.' '.$active.'<br>';
        $being_viewed = \Request::path() == rtrim(ltrim($page->path, '/'), '/') ? 'being_viewed' : '';

        $has_subs = ! $subs->isEmpty() ? 'has_subs' : '';

        foreach($paths as $k => $p) {
            $path .= "{$p}/";
        }

        // Commenta út ef þú vilt ekki sýna síður með "óþýdda" titla...
        // if(! $page->translation('title')) continue;

        $title = $page->translation('title') ?: $page->title;

        $menu .= "<li class='lvl-{$lvl} {$active} {$being_viewed} {$has_subs}'><a href='{$page->path}'>{$title}</a>";

        if($active || (isset($args['expand_all']) && $args['expand_all'])) {
            if(! $subs->isEmpty()) {
                $lvl++;
                kalMenu($args, $subs, $lvl, $menu, $paths);
                $lvl--;
            }
        }

        array_pop($paths);

        $menu .= "</li>";
    }

    $menu .= "</ul>";

    return $menu;
}

























function stringStartsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}
function stringEndsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}

















function kalFormatPrice($price)
{
    return number_format($price, 0, ',', '.').',- kr.';
}       














function makeAccordion($item) {
    if(strpos($item->content, '!accordion') == false) return $item->content;
    
    $subs = $item->getAccordionSubs();

    $html = "<div class='Accordion'>";

    foreach($subs as $sub) {
        $subContent = filterImages($sub);

        $html .= "<div class='Accordion--item'>";

            $html .= "<a class='Accordion--anchor'><h4>{$sub->title}</h4></a>";

            $html .= "<div class='Accordion--content'>";

                $html .= "$subContent";

            $html .= "</div>";

        $html .= "</div>"; /* end of item */
    }

    $html .= "</div>";
    

    $ret = str_replace('!accordion', $html, $item->content);

    return $ret;
}


function cmsContent($item) {
    $item->content = filterImages($item);
    $content = makeAccordion($item);
    return $content;
}




function filterImages($item) {
    $content = $item->content;
    $newContent = $content;

    $imgs = array();
    $idx = array();

    $pattern = '/{([(A-Za-z |:0-9)}]*)}/';

    if(preg_match_all($pattern, $content, $matches)) {
        $i = 0;
        foreach($matches[0] as $match) {
            $idx[$i] = $match;

            $i++;
        }

        $i = 0;
        foreach($matches[1] as $match) {
            $fields = explode('|', $match);

            foreach($fields as $field) {
                $e = explode(':', $field);
                $e[1] = isset($e[1]) ? $e[1] : '';
                $imgs[$i][trim(strtolower($e[0]))] = trim(strtolower($e[1]));
            }

            $i++;
        }

        $i = 0;
        foreach($imgs as $img) {
            $nr             = is_numeric($img['image']) && $img['image'] > 0 ? $img['image'] : $i;
            $title          = isset($img['title']) ? $img['title'] : '';
            $align          = isset($img['align']) ? $img['align'] : '';
            
            $imageClass     = '';
            $imageClass     .= isset($img['imageClass']) ? $img['imageClass'].' '.$imageClass : $imageClass;

            $size           = isset($img['size']) ? $img['size'] : 'large';
            $itemImage      = $item->img()->nr($nr);
            $image          = $itemImage ? $itemImage : false;

            switch($align) {
                case('left'):
                    $pos = 'lefter';
                    break;
                case('right'):
                    $pos = 'righter';
                    break;
                default:
                    $pos = 'lefter';
                    break;
            }
            
            $repl = '
                <figure class="'.$pos.'">
                    <img class=""
                         src="/imagecache/article/'.$itemImage.'"
                    />
                </figure>
            ';

            $newContent = preg_replace($pattern, $repl, $newContent, 1);

            $i++;
        }
    } else {
        return $content;
    }

    return $newContent;
}












function frontpage() {
    return \Request::is('/');
}