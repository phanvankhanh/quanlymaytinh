<?php
include_once('ketnoi.php');

// Lấy số trang hiện tại
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Thiết lập số lượng dòng hiển thị trên mỗi trang
$rowsPerPage = 10;

// Xác định vị trí bắt đầu của dữ liệu cần lấy
$perRow = ($page - 1) * $rowsPerPage;

// Truy vấn danh mục sản phẩm với giới hạn số lượng trang
$sql = "SELECT * FROM users ORDER BY id_user ASC LIMIT $perRow, $rowsPerPage";
$query = mysqli_query($conn, $sql);

// Truy vấn tổng số dòng trong bảng dmsanpham
$totalRows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));

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
        $listPage .= '<li class="active"><a href="quantri.php?page_layout=danhsachuserr&page=' . $i . '">' . $i . '</a></li>';
    } else {
        $listPage .= '<li><a href="quantri.php?page_layout=danhsachuser&page=' . $i . '">' . $i . '</a></li>';
    }
}
?>
<link rel="stylesheet" type="text/css" href="css/danhsachuser.css" />
<h2>Quản Lý User</h2>
<div class="danhsachuser">
    <div class="row" style="    display: flex;flex-wrap: wrap;margin-right: 2.25rem;margin-left: -.75rem;">
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
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <p id="add-sp"><a href="quantri.php?page_layout=themuser" style=" float: left;"><span>Thêm thành viên mới</span></a></p>
        <table id="sps" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr id="sp-bar">
                <td width="5%">ID</td>
                <td width="15%">Họ tên</td>
                <td width="10%">Tên đăng nhập</td>
                <!-- <td width="10%">Mật khẩu</td> -->
                <td width="5%">Giới tính</td>
                <td width="10%">Ngày sinh</td>
                <td width="5%">Địa chỉ</td>
                <td width="5%">Điện thoại</td>
                <!-- <td width="5%">Email</td> -->
                <td width="5%">Sửa</td>
                <td width="5%">Xóa</td>
            </tr>
            <?php
            while ($row = mysqli_fetch_array($query)) {
                // Xử lý dữ liệu trong vòng lặp
            ?>
                <tr>
                    <td><span><?php echo $row['id_user']; ?></span></td>
                    <td class="l5"><a href="quantri.php?page_layout=suauser&id_user=<?php echo $row['id_user']; ?>"><?php echo $row['name']; ?></a></td>
                    <td class="l5"><?php echo $row['username']; ?></span></td>
                    <!-- <td class="l5"><?php echo $row['password']; ?></span></td> -->
                    <td class="l5"><?php echo $row['gioi_tinh']; ?></span></td>
                    <td class="l5"><?php echo $row['ngay_sinh']; ?></span></td>
                    <td class="l5"><?php echo $row['dia_chi']; ?></span></td>
                    <td class="l5"><?php echo $row['dien_thoai'] ?></td>
                    <!-- <td class="l5"><?php echo $row['email'] ?></td> -->
                    <td><a href="quantri.php?page_layout=suauser&id_user=<?php echo $row['id_user']; ?>"><span>Sửa</span></a></td>
                    <td>
                        <!-- Cập nhật nút Xóa để hiển thị xác nhận -->
                        <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id_user']; ?>)">
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
    function confirmDelete(id_user) {
        // Hiển thị hộp thoại xác nhận
        var isConfirmed = confirm("Bạn có chắc chắn muốn xóa thành viên này không này?");
        if (isConfirmed) {
            // Nếu người dùng xác nhận, chuyển đến trang xóa sản phẩm
            window.location.href = "xoauser.php?id_user=" + id_user;
        }
    }
</script>
