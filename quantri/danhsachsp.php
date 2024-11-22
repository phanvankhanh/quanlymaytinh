<?php
include_once('ketnoi.php');

// Kiểm tra nếu có tham số 'page' trong URL, nếu không thì gán giá trị mặc định là 1
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$rowsPerPage = 10;  // Số lượng dòng hiển thị mỗi trang
$perRow = $page * $rowsPerPage - $rowsPerPage;  // Xác định vị trí bắt đầu của dữ liệu cần lấy

// Truy vấn dữ liệu sản phẩm với giới hạn số lượng trang
$sql = "SELECT * FROM sanpham INNER JOIN danhmuc ON sanpham.id_dm = danhmuc.id_dm ORDER BY id_sp ASC LIMIT $perRow, $rowsPerPage";
$query = mysqli_query($conn, $sql);

// Truy vấn tổng số dòng trong bảng sanpham
$totalRows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM sanpham"));

// Tính tổng số trang
$totalPage = ceil($totalRows / $rowsPerPage);

// Tạo liên kết phân trang
$listPage = '';
$maxPagesToShow = 5; // Số trang tối đa để hiển thị
$startPage = max(1, $page - floor($maxPagesToShow / 2));
$endPage = min($totalPage, $startPage + $maxPagesToShow - 1);

// Tạo liên kết phân trang
for ($i = $startPage; $i <= $endPage; $i++) {
    if ($page == $i) {
        $listPage .= '<li class="active"><a href="quantri.php?page_layout=danhsachsp&page=' . $i . '">' . $i . '</a></li>';
    } else {
        $listPage .= '<li><a href="quantri.php?page_layout=danhsachsp&page=' . $i . '">' . $i . '</a></li>';
    }
}
?>

<link rel="stylesheet" type="text/css" href="css/danhsachsp1.css" />
<h2>Quản Lý Sản Phẩm</h2>
<div class="danhsachsp">
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group" style="float: right;position: absolute;right: 84px;top: 174px;">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search" method="get" action="danhsachsp.php"> 
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <div class="row">
            <p id="add-sp"><a href="quantri.php?page_layout=themsp"><span>Thêm sản phẩm mới</span></a></p>
            <!-- Topbar Search -->

            <table id="sps" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr id="sp-bar">
                    <td width="5%">ID</td>
                    <td width="25%">Tên sản phẩm</td>
                    <td width="15%">Giá</td>
                    <td width="15%">Số lượng tồn</td>
                    <td width="20%">Nhà cung cấp</td>
                    <td width="10%">Hình ảnh</td>
                    <td width="5%">Sửa</td>
                    <td width="5%">Xóa</td>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                    // Xử lý dữ liệu trong vòng lặp
                    ?>
                    <tr>
                        <td><span><?php echo $row['id_sp']; ?></span></td>
                        <td class="l5"><a
                                href="quantri.php?page_layout=suasp&id_sp=<?php echo $row['id_sp']; ?>"><?php echo $row['ten_sp']; ?></a>
                        </td>
                        <td class="l5"><span class="price"><?php echo $row['don_gia']; ?></span></td>
                        <td class="l5"><?php echo $row['so_luong_ton']; ?></span></td>
                        <td class="l5"><?php echo $row['nha_san_xuat'] ?></td>
                        <td><span class="thumb"><img width="60" alt="Ảnh không tồn tại"
                                    src="images-laptop/<?php echo $row['hinh_anh']; ?>" /></span></td>
                        <td><a href="quantri.php?page_layout=suasp&id_sp=<?php echo $row['id_sp']; ?>"><span>Sửa</span></a>
                        </td>
                        <td>
                            <!-- Cập nhật nút Xóa để hiển thị xác nhận -->
                            <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id_sp']; ?>)">
                                <span>Xóa</span>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <div class="pagination">
                <ul>
                    <?php echo $listPage; ?>
                </ul>
            </div>
        </div>
</div>

<script type="text/javascript">
    function confirmDelete(id_sp) {
        var isConfirmed = confirm("Bạn có chắc chắn muốn xóa sản phẩm này?");
        if (isConfirmed) {
            window.location.href = "xoasp.php?id_sp=" + id_sp;
        }
    }
</script>
