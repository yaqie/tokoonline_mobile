<script>
    $(document).ready(function () {
        var pathname = $(location).attr('pathname');
        var pathfix = pathname.split('/')[2]

        let menu = $('.suha-footer-nav li').find(`a[href='${pathfix}']`).attr('href')
        if (menu == pathfix) {
            $('.suha-footer-nav li').find(`a[href='${pathfix}']`).parents("li").addClass('active');
            $('.suha-footer-nav li').find(`a[href='${pathfix}']`).attr('href','javascript:void(0)');
        }

    });
</script>
<!-- Footer Nav-->
<div class="footer-nav-area" id="footerNav">
    <div class="container h-100 px-0">
    <div class="suha-footer-nav h-100">
        <ul class="h-100 d-flex align-items-center justify-content-between pl-0">
        <li><a href="home"><i class="lni lni-home"></i>Home</a></li>
        <li><a href="category"><i class="lni lni-list"></i>Category</a></li>
        <li><a href="cart"><i class="lni lni-shopping-basket"></i>Cart</a></li>
        <li><a href="order"><i class="lni lni-files"></i>My Order</a></li>
        <!-- <li><a href="settings"><i class="lni lni-cog"></i>Settings</a></li> -->
        </ul>
    </div>
    </div>
</div>