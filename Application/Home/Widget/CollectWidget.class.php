<?php

namespace Home\Widget;
use Think\Controller;

class CollectWidget extends Controller{
    $this->assign("testW", "OK");
    $this->display('Widget/collect);
}
