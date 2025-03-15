<div class="navbar">
    <span class="item maintitle">Assurance</span>
    <div class="item-container">
    <?php 
        switch($_SERVER['REQUEST_URI']){
            case '/Vues/RH/home.php': ?>
                <a href="/Vues/RH/home.php" class="btn active"><i class="fas fa-home"></i> Accueil</a>
                <a href="/Vues/RH/register.php" class="btn"><i class="fas fa-user-plus"></i> Nouvel employe</a>
                <a href="" class="btn"><i class="fas fa-users"></i> Employes</a>
            <?php
            break;
            case '/Vues/RH/register.php': ?>
                <a href="/Vues/RH/home.php" class="btn"><i class="fas fa-home"></i> Accueil</a>
                <a href="/Vues/RH/register.php" class="btn active"><i class="fas fa-user-plus"></i> Nouvel employe</a>
                <a href="" class="btn"><i class="fas fa-users"></i> Employes</a>
            <?php
            break;
            case '/Vues/RH/employes.php': ?>
                <a href="/Vues/RH/home.php" class="btn"><i class="fas fa-home"></i> Accueil</a>
                <a href="/Vues/RH/register.php" class="btn"><i class="fas fa-user-plus"></i> Nouvel employe</a>
                <a href="" class="btn active"><i class="fas fa-users"></i> Employes</a>
            <?php
            default:
            echo $_SERVER['REQUEST_URI'];
        }
    ?>
    </div>
</div>