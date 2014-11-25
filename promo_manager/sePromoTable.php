<?php
// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {


    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class sePromoTable extends WP_List_Table
{
    public function __construct()
    {
        parent::__construct();
    }
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();

        $data = $this->data;



        $this->_column_headers  = array($columns, $hidden, $sortable);
        $this->column_headers  = array($columns, $hidden, $sortable);
        $this->items = $data;


    }
    public function get_columns()
    {
        $columns = array(
            'name'=>'Name',
            'tags'=>'Tags',
            'actions'=>'Actions'
        );

        return $columns;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {

            case 'name':
                return $item[ $column_name ];
            break;
            case "actions":
                $actions_html= "
                <a style='outline:none' href='javascript:;' class='deletePromotion' id='{$item['id']}' title='Delete'>
                    <img style='width:24px' src='".SE_IMAGES_URL."admin/blue_delete.png'/>
                </a>";

                $actions_html.= "
                <a style='outline:none' href='admin.php?page=".SE_SLUG."_promotions&manage={$item['id']}'  id='{$item['id']}' title='Manage Promotion'>
                    <img style='width:24px' src='".SE_IMAGES_URL."admin/blue_wrench.png'/>
                </a>";

                return $actions_html;
            break;
            case 'tags':

                $tags = $item[$column_name];

                $html = "";

                foreach($tags as $tag)
                {
                    $html .='<span id="JRreX_1" class="tm-tag tm-tag-info"><span>'.$tag['tag'].'</span></span>';
                }
                return $html;

            break;
        }
    }

    public  function get_table_classes()
    {
        return array('widefat', 'wp-list-table', 'themes');
    }
}