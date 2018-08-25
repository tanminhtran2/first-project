<?php
 


class Pagination
{
    /**
     * Biến config chứa tất cả các cấu hình
     * @var array
     */
    private $config = [
        'total'       => 0,
        'limit'       => 0,
        'full'        => false,
        'querystring' => 'page',
        'thietbi'     => '',
        'ajax'        => 0,
        'current_page' => 0,
        'thongbao' => 0,
        'log' => 0,
        'luachon_thietbi' => 0,
        'caidat' => 0,
        'xoathietbi' => 0,
        'xoa_user' => 0,
        'caidat_ngonngu' =>0,
    ];
    /**
     * khởi tạo
     * @param array $config
     */

    public function __construct($config = [])
    {
        if (isset($config['limit']) && $config['limit'] < 0 || isset($config['total']) && $config['total'] < 0) {
            die("<div style='margin-top:8px;color:red;'>Số lượng dòng không được nhỏ hơn không</div>");
        }

        if (!isset($config['querystring'])) {
            $config['querystring'] = 'page';
        }

        $this->config = $config;
    }
    /**
     * Lấy ra tổng số trang
     * @return int
     */
    private function gettotalPage()
    {
        return ceil($this->config['total'] / $this->config['limit']);
    }

    /**
     * Lấy ra trang hiện tại
     * @return int
     */
    public  function getCurrentPage()
    {
        if($this->config['ajax']==1){  
                return (int) $this->config['current_page'];
        }else{
            if (isset($_GET[$this->config['querystring']]) && (int) $_GET[$this->config['querystring']] >= 1) {
                 
                if ((int) $_GET[$this->config['querystring']] > $this->gettotalPage()) {
                    return (int) $this->gettotalPage();
                } else {
                    return (int) $_GET[$this->config['querystring']];
                }
            } else {
                return 1;
            }
        }
            
    }

    /**
     * lấy ra trang phía trước
     * @return string
     */
    private function getPrePage()
    {
        if($this->config['ajax']==1){ 
            if ($this->getCurrentPage() === 1) {
                return;
            }else{
                return '<a class="page"  >Pre</a>';
            }
                
        }else{
             if ($this->getCurrentPage() === 1) {
                return;
            }elseif($this->config['thongbao']==1){  
                return'<a href="thongbao.php?page=' .  ($this->getCurrentPage() - 1) . '" >Pre</a>';
            }elseif($this->config['log']==1){  
                return'<a href="log.php?page=' .  ($this->getCurrentPage() - 1) . '" >Pre</a>'; 
            }elseif($this->config['luachon_thietbi']==1){  
                return'<a href="luachon_thietbi.php?page=' .  ($this->getCurrentPage() - 1) . '" >Pre</a>';  
            }elseif($this->config['caidat']==1){  
                return'<a href="caidat.php?page=' .  ($this->getCurrentPage() - 1) . '" >Pre</a>';  
            }elseif($this->config['xoathietbi']==1){  
                return'<a href="xoathietbi.php?page=' .  ($this->getCurrentPage() - 1) . '" >Pre</a>'; 
             }elseif($this->config['xoa_user']==1){  
                return'<a href="xoa_user.php?page=' .  ($this->getCurrentPage() - 1) . '" >Pre</a>';  
            }elseif($this->config['caidat_ngonngu']==1){  
                return'<a href="caidat_ngonngu.php?page=' .  ($this->getCurrentPage() - 1) . '" >Pre</a>';  
            } else {
                return '<a href="lichsu.php?thietbi=' . $this->config['thietbi'].'&'. $this->config['querystring'] . '=' . ($this->getCurrentPage() - 1) . '" >Pre</a>';
            }
        }
           
    }
 
    /**
     * Lấy ra trang phía sau
     * @return string
     */
    private function getNextPage()
    {
        if($this->config['ajax']==1){ 
            if ($this->getCurrentPage() >= $this->gettotalPage()) {
                return;
            }else{
                return '<a class="page"  >Next</a>';
            }
        }else{
            if ($this->getCurrentPage() >= $this->gettotalPage()) {
                return;
            }elseif($this->config['thongbao']==1){  
                return'<a href="thongbao.php?page=' .  ($this->getCurrentPage() + 1) . '" >Next</a>';
            }elseif($this->config['log']==1){  
                return'<a href="log.php?page=' .  ($this->getCurrentPage() + 1) . '" >Next</a>';
            }elseif($this->config['luachon_thietbi']==1){  
                return'<a href="luachon_thietbi.php?page=' .  ($this->getCurrentPage() + 1) . '" >Next</a>';
            }elseif($this->config['caidat']==1){  
                return'<a href="caidat.php?page=' .  ($this->getCurrentPage() + 1) . '" >Next</a>';
            }elseif($this->config['xoathietbi']==1){  
                return'<a href="xoathietbi.php?page=' .  ($this->getCurrentPage() + 1) . '" >Next</a>';
            }elseif($this->config['xoa_user']==1){  
                return'<a href="xoa_user.php?page=' .  ($this->getCurrentPage() + 1) . '" >Next</a>';
            }elseif($this->config['caidat_ngonngu']==1){  
                return'<a href="caidat_ngonngu.php?page=' .  ($this->getCurrentPage() + 1) . '" >Next</a>';
            } else {
                return'<a href="lichsu.php?thietbi=' . $this->config['thietbi'].'&'. $this->config['querystring'] . '=' . ($this->getCurrentPage() + 1) . '" >Next</a>';
            }
        }
    }

    /**
     * Hiển thị html code của page
     * @return string
     */
    public function getPagination()
    {
        $data = '';

        if (isset($this->config['full']) && $this->config['full'] === false) {
            $data .= ($this->getCurrentPage() - 4) > 1 ? '<a>...</a>' : '';

            for ($i = ($this->getCurrentPage() - 4) > 0 ? ($this->getCurrentPage() - 4) : 1; $i <= (($this->getCurrentPage() + 4) > $this->gettotalPage() ? $this->gettotalPage() : ($this->getCurrentPage() + 4)); $i++) {
                if($this->config['ajax']===1){        
                    if ($i === $this->getCurrentPage()) {
                        $data .= '<a class="active"  >' . $i . '</a>';
                    } else {
                         
                        $data .= '<a class="page"  >' . $i . '</a>';
                    }
                }elseif($this->config['thongbao']==1){
                    if ($i === $this->getCurrentPage()) {
                        $data .= '<a class="active" href="#" >' . $i . '</a>';
                    } else {
                        $data .= '<a href="thongbao.php?&page=' . $i . ' ">' . $i . '</a>';
                    }
                }elseif($this->config['log']==1){
                    if ($i === $this->getCurrentPage()) {
                        $data .= '<a class="active" href="#" >' . $i . '</a>';
                    } else {
                        $data .= '<a href="log.php?&page=' . $i . ' ">' . $i . '</a>';
                    }
                }elseif($this->config['luachon_thietbi']==1){
                    if ($i === $this->getCurrentPage()) {
                        $data .= '<a class="active" href="#" >' . $i . '</a>';
                    } else {
                        $data .= '<a href="luachon_thietbi.php?&page=' . $i . ' ">' . $i . '</a>';
                    }
                }elseif($this->config['caidat']==1){
                    if ($i === $this->getCurrentPage()) {
                        $data .= '<a class="active" href="#" >' . $i . '</a>';
                    } else {
                        $data .= '<a href="caidat.php?&page=' . $i . ' ">' . $i . '</a>';
                    }
                }elseif($this->config['xoathietbi']==1){
                    if ($i === $this->getCurrentPage()) {
                        $data .= '<a class="active" href="#" >' . $i . '</a>';
                    } else {
                        $data .= '<a href="xoathietbi.php?&page=' . $i . ' ">' . $i . '</a>';
                    }
                 }elseif($this->config['xoa_user']==1){
                    if ($i === $this->getCurrentPage()) {
                        $data .= '<a class="active" href="#" >' . $i . '</a>';
                    } else {
                        $data .= '<a href="xoa_user.php?&page=' . $i . ' ">' . $i . '</a>';
                    }
                }elseif($this->config['caidat_ngonngu']==1){
                    if ($i === $this->getCurrentPage()) {
                        $data .= '<a class="active" href="#" >' . $i . '</a>';
                    } else {
                        $data .= '<a href="caidat_ngonngu.php?&page=' . $i . ' ">' . $i . '</a>';
                    }
                }else{
                    if ($i === $this->getCurrentPage()) {
                        $data .= '<a class="active" href="#" >' . $i . '</a>';
                    } else {
                        $data .= '<a href="lichsu.php?thietbi=' . $this->config['thietbi'].'&'. $this->config['querystring'] . '=' . $i . ' ">' . $i . '</a>';
                    }
                }


                    
            }

            $data .= ($this->getCurrentPage() + 4) < $this->gettotalPage() ? '<a>...</a>' : '';
        } else {    //lay full phan trang
            for ($i = 1; $i <= $this->gettotalPage(); $i++) {

                if ($i === $this->getCurrentPage()) {
                    $data .= '<a class="active" href="#" >' . $i . '</a>';
                } else {
                    $data .= '<a href="' . $_SERVER['PHP_SELF'] . '?' . $this->config['querystring'] . '=' . $i . '" >' . $i . '</a>';
                }
            }
        }

        return "<div id='pagination' class='pagination' style='float:left; position: ;'>" . $this->getPrePage() . $data . $this->getNextPage() . '</div>';
    }
}
 
?>
