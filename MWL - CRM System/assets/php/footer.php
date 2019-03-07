<footer class="footer">
    <div class="container-fluid">
        <nav class="pull-left">
            <ul>
                <li>
                    <a href="index.php">
                      Logged in as <b> <?php echo $_SESSION['adminDetails']->username; ?> </b>
                    </a>
                </li>
    			 <li class="mobile-hidden">
                    <a href="#">
                       |
                    </a>
                </li>
                <li>
                    <a href="http://www.kaloyanbozhkov.com">
                        Kaloyan Bozhkov
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</footer>