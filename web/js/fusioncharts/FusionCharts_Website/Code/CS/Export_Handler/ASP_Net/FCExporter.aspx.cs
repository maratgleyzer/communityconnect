/ * *  
   *  
   *   F u s i o n C h a r t s   E x p o r t e r   i s   a n   A S P . N E T   C #   s c r i p t   t h a t   h a n d l e s    
   *   F u s i o n C h a r t s   ( s i n c e   v 3 . 1 )   S e r v e r   S i d e   E x p o r t   f e a t u r e .  
   *   T h i s   i n   c o n j u n c t u r e   w i t h   v a r i o u s   e x p o r t   c l a s s e s   w o u l d    
   *   p r o c e s s   F u s i o n C h a r t s   E x p o r t   D a t a   P O S T E D   t o   i t   f r o m   F u s i o n C h a r t s    
   *   a n d   c o n v e r t   t h e   d a t a   t o   i m a g e   o r   P D F   a n d   s u b s e q u e n t l y   s a v e   t o   t h e    
   *   s e r v e r   o r   r e s p o n s e   b a c k   a s   h t t p   r e s p o n s e   t o   c l i e n t   s i d e   a s   d o w n l o a d .  
   *  
   *   T h i s   s c r i p t   m i g h t   b e   c a l l e d   a s   t h e   F u s i o n C h a r t s   E x p o r t e r   -   m a i n   m o d u l e    
   *  
   *         @ a u t h o r   F u s i o n C h a r t s  
   *         @ d e s c r i p t i o n   F u s i o n C h a r t s   E x p o r t e r   ( S e r v e r - S i d e   -   A S P . N E T   C # )  
   *         @ v e r s i o n   2 . 0   [   2 2   F e b r u a r y   2 0 0 9   ]  
   *      
   * /  
 / * *  
   *     C h a n g e L o g   /   V e r s i o n   H i s t o r y :  
   *     - - - - - - - - - - - - - - - - - - - - - - - - - - - -  
   *  
   *       2 . 0   [   1 2   F e b r u a r y   2 0 0 9   ]    
   *               -   I n t e g r a t e d   w i t h   n e w   E x p o r t   f e a t u r e   o f   F u s i o n C h a r t s   3 . 1  
   *               -   c a n   s a v e   t o   s e r v e r   s i d e   d i r e c t o r y  
   *               -   c a n   p r o v i d e   d o w n l o a d   o r   o p e n   i n   p o p u p   w i n d o w .  
   *               -   c a n   r e p o r t   b a c k   t o   c h a r t  
   *               -   c a n   s a v e   a s   P D F / J P G / P N G / G I F  
   *  
   *       1 . 0   [   1 6   A u g u s t   2 0 0 7   ]  
   *               -   c a n   p r o c e s s   c h a r t   d a t a   t o   j p g   i m a g e   a n d   r e s p o n s e   b a c k   t o   c l i e n t   s i d e   a s   d o w n l o a d .  
   *  
   * /  
 / * *  
   *   C o p y r i g h t   ( c )   2 0 0 9   I n f o S o f t   G l o b a l   P r i v a t e   L i m i t e d .   A l l   R i g h t s   R e s e r v e d  
   *    
   * /  
 / * *  
   *     G E N E R A L   N O T E S  
   *     - - - - - - - - - - - - -  
   *  
   *     C h a r t   w o u l d   P O S T   e x p o r t   d a t a   ( w h i c h   c o n s i s t s   o f   e n c o d e d   i m a g e   d a t a   s t r e a m ,      
   *     w i d t h ,   h e i g h t ,   b a c k g r o u n d   c o l o r   a n d   v a r i o u s   o t h e r   e x p o r t   p a r a m e t e r s   l i k e    
   *     e x p o r t F o r m a t ,   e x p o r t F i l e N a m e ,   e x p o r t A c t i o n ,   e x p o r t T a r g e t W i n d o w )   t o   t h i s   s c r i p t .    
   *      
   *     T h e   s c r i p t   w o u l d   p r o c e s s   t h i s   d a t a   u s i n g   a p p r o p r i a t e   r e s o u r c e   c l a s s e s   &   b u i l d    
   *     e x p o r t   b i n a r y   ( P D F / i m a g e )    
   *  
   *     I t   e i t h e r   s a v e s   t h e   b i n a r y   a s   f i l e   t o   a   s e r v e r   s i d e   d i r e c t o r y   o r   p u s h   i t   a s  
   *     D o w n l o a d   t o   c l i e n t   s i d e .  
   *  
   *  
   *     I S S U E S  
   *     - - - - - -  
   *       Q .   W h a t   i f   s o m e o n e   w i s h e s   t o   o p e n   i n   t h e   s a m e   p a g e   w h e r e   t h e   c h a r t   e x i s t e d   a s   p o s t b a c k  
   *             r e p l a c i n g   t h e   o l d   p a g e ?  
   *    
   *       A .   N o t   d i r e c t l y   s u p p o r t e d   u s i n g   a n y   c h a r t   a t t r i b u t e   o r   p a r a m e t e r   b u t   c a n   d o   b y  
   *             r e m o v i n g / c o m m e n t i n g   t h e   l i n e   c o n t a i n i n g   ' h e a d e r (   c o n t e n t - d i s p o s i t i o n   . . . '  
   *            
   * /  
 / * *  
   *    
   *       @ r e q u i r e s 	 F C I M G G e n e r a t o r     C l a s s   t o   e x p o r t   F u s i o n C h a r t s   i m a g e   d a t a   t o   J P G ,   P N G ,   G I F   b i n a r y  
   *       @ r e q u i r e s     F C P D F G e n e r a t o r     C l a s s   t o   e x p o r t   F u s i o n C h a r t s   i m a g e   d a t a   t o   P D F   b i n a r y  
   *  
   * /  
  
 u s i n g   S y s t e m ;  
 u s i n g   S y s t e m . I O ;  
 u s i n g   S y s t e m . W e b ;  
 u s i n g   S y s t e m . D r a w i n g ;  
 u s i n g   S y s t e m . C o l l e c t i o n s ;  
 u s i n g   S y s t e m . D r a w i n g . I m a g i n g ;  
 u s i n g   S y s t e m . T e x t . R e g u l a r E x p r e s s i o n s ;  
  
 / / /   < s u m m a r y >  
 / / /   F u s i o n C h a r t s   E x p o r t e r   i s   a n   A S P . N E T   C #   s c r i p t   t h a t   h a n d l e s    
 / / /   F u s i o n C h a r t s   ( s i n c e   v 3 . 1 )   S e r v e r   S i d e   E x p o r t   f e a t u r e .  
 / / /   T h i s   i n   c o n j u n c t u r e   w i t h   o t h e r   r e s o u r c e   c l a s s e s   w o u l d    
 / / /   p r o c e s s   F u s i o n C h a r t s   E x p o r t   D a t a   P O S T E D   t o   i t   f r o m   F u s i o n C h a r t s    
 / / /   a n d   c o n v e r t   t h e   d a t a   t o   a n   i m a g e   o r   a   P D F .   S u b s e q u e n t l y ,   i t   w o u l d   s a v e    
 / / /   t o   t h e   s e r v e r   o r   r e s p o n d   b a c k   a s   a n   H T T P   r e s p o n s e   t o   c l i e n t   s i d e   a s   d o w n l o a d .  
 / / /    
 / / /   T h i s   s c r i p t   m i g h t   b e   c a l l e d   a s   t h e   F u s i o n C h a r t s   E x p o r t e r   -   m a i n   m o d u l e  
 / / /   < / s u m m a r y >  
 / / /    
 p u b l i c   p a r t i a l   c l a s s   F C E x p o r t e r   :   S y s t e m . W e b . U I . P a g e  
 {  
  
  
         / / /   < s u m m a r y >  
         / / /   I M P O R T A N T :   Y o u   n e e d   t o   c h a n g e   t h e   l o c a t i o n   o f   f o l d e r   w h e r e    
         / / /   t h e   e x p o r t e d   c h a r t   i m a g e s / P D F s   w i l l   b e   s a v e d   o n   y o u r    
         / / /   s e r v e r .   P l e a s e   s p e c i f y   t h e   p a t h   t o   a   f o l d e r   w i t h    
         / / /   w r i t e   p e r m i s s i o n s   i n   t h e   c o n s t a n t   S A V E _ P A T H   b e l o w .    
         / / /    
         / / /   P l e a s e   p r o v i d e   t h e   p a t h   a s   p e r   A S P . N E T   p a t h   c o n v e n t i o n s .    
         / / /   Y o u   c a n   u s e   r e l a t i v e   o r     a b s o l u t e   p a t h .  
         / / /    
         / / /   S p e c i a l   C a s e s :    
         / / /           ' / '   m e a n s   ' w w w r o o t '   d i r e c t o r y .  
         / / /           ' .   / '   (   w i t h o u t   t h e   s p a c e   a f t e r   . )   i s   t h e   d i r e c t o r y   w h e r e   t h e   F C E x p o r t e r . a s p x   f i l e   r e c i d e s .  
         / / /            
         / / /   A b s o l u t e   P a t h   :  
         / / /    
         / / /           c a n   b e   l i k e   t h i s   :   " C : \ \ m y F o l d e r s \ \ m y I m a g e s "    
         / / /           (   P l e a s e   n e v e r   u s e   s i n g l e   b a c k s l a s h   a s   t h a t   w o u l d   s t o p   e x e c u t i o n   o f   t h e   c o d e   i n s t a n t l y )  
         / / /           o r   " C : / m y F o l d e r s / m y I m a g e s "  
         / / /    
         / / /           Y o u   m a y   h a v e   a   / /   o r   \   a t   e n d   :   " C : \ \ m y F o l d e r s \ \ m y I m a g e s \ \ "     o r   " C : / m y F o l d e r s / m y I m a g e s / "  
         / / /    
         / / /           Y o u   c a n   a l s o   h a v e   m i x e d   s l a s h e s   :   " C : \ \ m y F o l d e r s / m y I m a g e s "    
         / / /            
         / / /    
         / / /   < / s u m m a r y >  
         / / /   d i r e c t o r y   w h e r e   t h e   F C E x p o r t e r . a s p x   f i l e   r e c i d e s  
         p r i v a t e   c o n s t   s t r i n g   S A V E _ P A T H   =   " . . / . . / E x p o r t / E x p o r t e d _ I m a g e s " ;  
  
         / / /   < s u m m a r y >  
         / / /   I M P O R T A N T :   T h i s   c o n s t a n t   H T T P _ U R I   s t o r e s   t h e   H T T P   r e f e r e n c e   t o    
         / / /   t h e   f o l d e r   w h e r e   e x p o r t e d   c h a r t s   w i l l   b e   s a v e d .    
         / / /   P l e a s e   e n t e r   t h e   H T T P   r e p r e s e n t a t i o n   o f   t h a t   f o l d e r    
         / / /   i n   t h i s   c o n s t a n t   e . g . ,   h t t p : / / w w w . y o u r d o m a i n . c o m / i m a g e s /  
         / / /   < / s u m m a r y >  
         p r i v a t e   c o n s t   s t r i n g   H T T P _ U R I   =   " E x p o r t e d _ I m a g e s / " ;  
  
         / / /   < s u m m a r y >  
         / / /   O V E R W R I T E F I L E   s e t s   w h e t h e r   t h e   e x p o r t   h a n d l e r   w o u l d   o v e r w r i t e   a n   e x i s t i n g   f i l e    
         / / /   t h e   n e w l y   c r e a t e d   e x p o r t e d   f i l e .   I f   i t   i s   s e t   t o   f a l s e   t h e   e x p o r t   h a n d l e r   w o u l d  
         / / /   n o t   o v e r w r i t e .   I n   t h i s   c a s e ,   i f   I N T E L L I G E N T F I L E N A M I N G   i s   s e t   t o   t r u e   t h e   h a n d l e r  
         / / /   w o u l d   a d d   a   s u f f i x   t o   t h e   n e w   f i l e   n a m e .   T h e   s u f f i x   i s   a   r a n d o m l y   g e n e r a t e d   G U I D .  
         / / /   A d d i t i o n a l l y ,   y o u   a d d   a   t i m e s t a m p   o r   a   r a n d o m   n u m b e r   a s   a d d i t i o n a l   s u f f i x .  
         / / /   < / s u m m a r y >  
         p r i v a t e   b o o l   O V E R W R I T E F I L E   =   f a l s e ;  
         p r i v a t e   b o o l   I N T E L L I G E N T F I L E N A M I N G   =   t r u e ;  
         p r i v a t e   s t r i n g   F I L E S U F F I X F O R M A T   =   " T I M E S T A M P " ; / /   / /   v a l u e   c a n   b e   e i t h e r   ' T I M E S T A M P '   o r   ' R A N D O M '  
  
  
         / / /   < s u m m a r y >  
         / / /   T h i s   i s   a   c o n s t a n t   l i s t   o f   t h e   M I M E   t y p e s   r e l a t e d   t o   e a c h   e x p o r t   f o r m a t   t h i s   r e s o u r c e   h a n d l e s  
         / / /   T h e   v a l u e   i s   s e m i c o l o n   s e p a r a t e d   k e y   v a l u e   p a i r   f o r   e a c h   f o r m a t  
         / / /   E a c h   k e y   i s   t h e   f o r m a t   a n d   v a l u e   i s   t h e   M I M E   t y p e  
         / / /   < / s u m m a r y >  
         p r i v a t e   c o n s t   s t r i n g   M I M E T Y P E S   =   " p d f = a p p l i c a t i o n / p d f ; j p g = i m a g e / j p e g ; j p e g = i m a g e / j p e g ; g i f = i m a g e / g i f ; p n g = i m a g e / p n g " ;  
  
         / / /   < s u m m a r y >  
         / / /   T h i s   i s   a   c o n s t a n t   l i s t   o f   a l l   t h e   f i l e   e x t e n s i o n s   f o r   t h e   e x p o r t   f o r m a t s  
         / / /   T h e   v a l u e   i s   s e m i c o l o n   s e p a r a t e d   k e y   v a l u e   p a i r   f o r   e a c h   f o r m a t  
         / / /   E a c h   k e y   i s   t h e   f o r m a t   a n d   v a l u e   i s   t h e   f i l e   e x t e n s i o n    
         / / /   < / s u m m a r y >  
         p r i v a t e   c o n s t   s t r i n g   E X T E N S I O N S   =   " p d f = p d f ; j p g = j p g ; j p e g = j p g ; g i f = g i f ; p n g = p n g " ;  
  
         / / /   < s u m m a r y >  
         / / /   L i s t s   t h e   d e f a u l t   e x p o r t P a r a m e t e r   v a l u e s   t a k e n ,   i f   n o t   p r o v i d e d   b y   c h a r t  
         / / /   < / s u m m a r y >  
         p r i v a t e   c o n s t   s t r i n g   D E F A U L T P A R A M S   =   " e x p o r t f i l e n a m e = F u s i o n C h a r t s ; e x p o r t f o r m a t = P D F ; e x p o r t a c t i o n = d o w n l o a d ; e x p o r t t a r g e t w i n d o w = _ s e l f " ;  
  
         / / /   < s u m m a r y >  
         / / /   S t o r e s   s e r v e r   n o t i c e s ,   i f   a n y   a s   s t r i n g   [   t o   b e   s e n t   b a c k   t o   c h a r t   a f t e r   s a v e   ]    
         / / /   < / s u m m a r y >  
         p r i v a t e   s t r i n g   n o t i c e s   =   " " ;  
         / / /   < s u m m a r y >  
         / / /   W h e t h e r   t h e   e x p o r t   a c t i o n   i s   d o w n l o a d .   D e f a u l t   v a l u e .   W o u l d   c h a n g e   a s   p e r   s e t t i n g   r e t r i e v e d   f r o m   c h a r t .  
         / / /   < / s u m m a r y >  
         p r i v a t e   b o o l   i s D o w n l o a d   =   t r u e ;  
  
         / / /   < s u m m a r y >  
         / / /   D O M I d   o f   t h e   c h a r t  
         / / /   < / s u m m a r y >  
         p r i v a t e   s t r i n g   D O M I d ;  
  
  
         / / /   < s u m m a r y >  
         / / /   T h e   m a i n   f u n c t i o n   t h a t   h a n d l e s   a l l   I n p u t   -   P r o c e s s   -   O u t p u t   o f   t h i s   E x p o r t   A r c h i t e c t u r e  
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " s e n d e r " > F u s i o n C h a r t s   c h a r t   S W F < / p a r a m >  
         / / /   < p a r a m   n a m e = " e " > < / p a r a m >  
         p r o t e c t e d   v o i d   P a g e _ L o a d ( o b j e c t   s e n d e r ,   E v e n t A r g s   e )  
         {  
  
                 / * *  
                   *   R e t r i e v e   e x p o r t   d a t a   f r o m   P O S T   R e q u e s t   s e n t   b y   c h a r t  
                   *   P a r s e   t h e   R e q u e s t   s t r e a m   i n t o   e x p o r t   d a t a   r e a d a b l e   b y   t h i s   s c r i p t  
                   * /  
                 H a s h t a b l e   e x p o r t D a t a   =   p a r s e E x p o r t R e q u e s t S t r e a m ( ) ;  
  
                 / /   p r o c e s s   e x p o r t   d a t a   a n d   g e t   t h e   p r o c e s s e d   d a t a   ( i m a g e / P D F )   t o   b e   e x p o r t e d  
                 M e m o r y S t r e a m   e x p o r t O b j e c t   =   e x p o r t P r o c e s s o r ( ( ( H a s h t a b l e ) e x p o r t D a t a [ " p a r a m e t e r s " ] ) [ " e x p o r t f o r m a t " ] . T o S t r i n g ( ) ,   e x p o r t D a t a [ " s t r e a m " ] . T o S t r i n g ( ) ,   ( H a s h t a b l e ) e x p o r t D a t a [ " m e t a " ] ) ;  
  
  
                 / *  
                   *   S e n d   t h e   e x p o r t   b i n a r y   t o   o u t p u t   m o d u l e   w h i c h   w o u l d   e i t h e r   s a v e   t o   a   s e r v e r   d i r e c t o r y  
                   *   o r   s e n d   t h e   e x p o r t   f i l e   t o   d o w n l o a d .   D o w n l o a d   t e r m i n a t e s   t h e   p r o c e s s   w h i l e  
                   *   a f t e r   s a v e   t h e   o u t p u t   m o d u l e   s e n d s   b a c k   e x p o r t   s t a t u s    
                   * /  
                 o b j e c t   e x p o r t e d S t a t u s   =   o u t p u t E x p o r t O b j e c t ( e x p o r t O b j e c t ,   ( H a s h t a b l e ) e x p o r t D a t a [ " p a r a m e t e r s " ] ) ;  
  
                 / /   D i s p o s e   e x p o r t   o b j e c t  
                 e x p o r t O b j e c t . C l o s e ( ) ;  
                 e x p o r t O b j e c t . D i s p o s e ( ) ;  
  
                 / *  
                   *   B u i l d   A p p r o p r i a t e   E x p o r t   S t a t u s   a n d   s e n d   b a c k   t o   c h a r t   b y   f l u s h i n g   t h e      
                   *   p r o c e s e d   s t a t u s   t o   h t t p   r e s p o n s e .   T h i s   r e t u r n s   s t a t u s   b a c k   t o   c h a r t .    
                   *   [   T h i s   i s   n o t   a p p l i c a b l e   w h e n   D o w n l o a d   a c t i o n   t o o k   p l a c e   ]  
                   * /  
                 f l u s h S t a t u s ( e x p o r t e d S t a t u s ,   ( H a s h t a b l e ) e x p o r t D a t a [ " m e t a " ] ) ;  
  
         }  
  
         / / /   < s u m m a r y >  
         / / /   P a r s e s   P O S T   s t r e a m   f r o m   c h a r t   a n d   b u i l d s   a   H a s h t a b l e   c o n t a i n i n g    
         / / /   e x p o r t   d a t a   a n d   p a r a m e t e r s   i n   a   f o r m a t   r e a d a b l e   b y   o t h e r   f u n c t i o n s .  
         / / /     T h e   H a s h t a b l e   c o n t a i n s   k e y s   ' s t r e a m '   ( c o n t a i n s   e n c o d e d    
         / / /   i m a g e   d a t a )   ;   ' m e t a '   (   H a s h t a b l e   w i t h   ' w i d t h ' ,   ' h e i g h t '   a n d   ' b g C o l o r '   k e y s )   ;  
         / / /   a n d   ' p a r a m e t e r s '   (   H a s h t a b l e   o f   a l l   e x p o r t   p a r a m e t e r s   f r o m   c h a r t   a s   k e y s ,   l i k e   -   e x p o r t F o r m a t ,    
         / / /   e x p o r t F i l e N a m e ,   e x p o r t A c t i o n   e t c . )  
         / / /   < / s u m m a r y >  
         / / /   < r e t u r n s > H a s h t a b l e   o f   p r o c e s s e d   e x p o r t   d a t a   a n d   p a r a m e t e r s . < / r e t u r n s >  
         p r i v a t e   H a s h t a b l e   p a r s e E x p o r t R e q u e s t S t r e a m ( )  
         {  
                 / /   s t o r e   a l l   e x p o r t   d a t a  
                 H a s h t a b l e   e x p o r t D a t a   =   n e w   H a s h t a b l e ( ) ;  
  
                 / / S t r i n g   o f   c o m p r e s s e d   i m a g e   d a t a  
                 e x p o r t D a t a [ " s t r e a m " ]   =   R e q u e s t [ " s t r e a m " ] ;  
  
                 / / H a l t   e x e c u t i o n     i f   i m a g e   s t r e a m   i s   n o t   p r o v i d e d .  
                 i f   ( R e q u e s t [ " s t r e a m " ]   = =   n u l l   | |   R e q u e s t [ " s t r e a m " ] . T r i m ( )   = =   " " )   r a i s e _ e r r o r ( " 1 0 0 " ,   t r u e ) ;  
  
                 / / G e t   a l l   e x p o r t   p a r a m e t e r s   i n t o   a   H a s t a b l e  
                 H a s h t a b l e   p a r a m e t e r s   =   p a r s e P a r a m s ( R e q u e s t [ " p a r a m e t e r s " ] ) ;  
                 e x p o r t D a t a [ " p a r a m e t e r s " ]   =   p a r a m e t e r s ;  
  
                 / / g e t   w i d t h   a n d   h e i g h t   o f   t h e   c h a r t  
                 H a s h t a b l e   m e t a   =   n e w   H a s h t a b l e ( ) ;  
  
                 m e t a [ " w i d t h " ]   =   R e q u e s t [ " m e t a _ w i d t h " ] ;  
                 / / H a l t   e x e c u t i o n   o n   e r r o r  
                 i f   ( R e q u e s t [ " m e t a _ w i d t h " ]   = =   n u l l   | |   R e q u e s t [ " m e t a _ w i d t h " ] . T r i m ( )   = =   " " )   r a i s e _ e r r o r ( " 1 0 1 " ,   t r u e ) ;  
  
                 m e t a [ " h e i g h t " ]   =   R e q u e s t [ " m e t a _ h e i g h t " ] ;  
                 / / H a l t   e x e c u t i o n   o n   e r r o r  
                 i f   ( R e q u e s t [ " m e t a _ h e i g h t " ]   = =   n u l l   | |   R e q u e s t [ " m e t a _ h e i g h t " ] . T r i m ( )   = =   " " )   r a i s e _ e r r o r ( " 1 0 1 " ,   t r u e ) ;  
  
  
                 / / B a c k g r o u n d   c o l o r   o f   c h a r t  
                 m e t a [ " b g c o l o r " ]   =   R e q u e s t [ " m e t a _ b g C o l o r " ] ;  
                 i f   ( R e q u e s t [ " m e t a _ b g C o l o r " ]   = =   n u l l   | |   R e q u e s t [ " m e t a _ b g C o l o r " ] . T r i m ( )   = =   " " )  
                 {  
                         / /   S e n d   n o t i c e   i f   B g C o l o r   i s   n o t   p r o v i d e d  
                         r a i s e _ e r r o r ( "   B a c k g r o u n d   c o l o r   n o t   s p e c i f i e d .   T a k i n g   W h i t e   ( F F F F F F )   a s   d e f a u l t   b a c k g r o u n d   c o l o r . " ) ;  
                         / /   S e t   W h i t e   a s   D e f a u l t   B a c k g r o u n d   c o l o r  
                         m e t a [ " b g c o l o r " ]   =   m e t a [ " b g c o l o r " ] . T o S t r i n g ( ) . T r i m ( )   = =   " "   ?   " F F F F F F "   :   m e t a [ " b g c o l o r " ] ;  
                 }  
  
                 / /   D O M I d   o f   t h e   c h a r t  
                 m e t a [ " D O M I d " ]   =   R e q u e s t [ " m e t a _ D O M I d " ]   = =   n u l l   ?   " "   :   R e q u e s t [ " m e t a _ D O M I d " ] ;  
                 D O M I d   =   m e t a [ " D O M I d " ] . T o S t r i n g ( ) ;  
  
                 e x p o r t D a t a [ " m e t a " ]   =   m e t a ;  
  
                 r e t u r n   e x p o r t D a t a ;  
         }  
  
         / / /   < s u m m a r y >  
         / / /   P a r s e   e x p o r t   ' p a r a m e t e r s '   s t r i n g   i n t o   a   H a s h t a b l e    
         / / /   A l s o   s y n c h r o n i s e   d e f a u l t   v a l u e s   f r o m   d e f a u l t p a r a m e t e r V a l u e s   H a s h t a b l e  
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " s t r P a r a m s " > A   s t r i n g   w i t h   p a r a m e t e r s   ( k e y = v a l u e   p a i r s )   s e p a r a t e d     b y   |   ( p i p e ) < / p a r a m >  
         / / /   < r e t u r n s > H a s h t a b l e   c o n t a i n i n g   p a r s e d   k e y   =   v a l u e   p a i r s . < / r e t u r n s >  
         p r i v a t e   H a s h t a b l e   p a r s e P a r a m s ( s t r i n g   s t r P a r a m s )  
         {  
  
                 / / d e f a u l t   p a r a m e t e r   v a l u e s  
                 H a s h t a b l e   d e f a u l t P a r a m e t e r V a l u e s   =   b a n g ( D E F A U L T P A R A M S ) ;  
  
                 / /   g e t   p a r a m e t e r s  
                 H a s h t a b l e   p a r a m e t e r s   =   b a n g ( s t r P a r a m s ,   n e w   c h a r [ ]   {   ' | ' ,   ' = '   } ) ;  
  
                 / /   s y n c   w i t h   d e f a u l t   v a l u e s  
                 / /   i t e r a t e   t h r o u g h   e a c h   d e f a u l t   p a r a m e t e r   v a l u e  
                 f o r e a c h   ( D i c t i o n a r y E n t r y   p a r a m   i n   d e f a u l t P a r a m e t e r V a l u e s )  
                 {  
                         / /   i f   a   p a r a m e t e r   f r o m   t h e   d e f a u l t P a r a m e t e r V a l u e s   H a s h t a b l e   i s   n o t   p r e s e n t  
                         / /   i n   t h e   p a r a m e t e r s   h a s h t a b l e   t a k e   t h e   p a r a m e t e r   a n d   v a l u e   f r o m   d e f a u l t  
                         / /   p a r a m e t e r   h a s h t a b l e   a n d   a d d   i t   t o   p a r a m s   h a s h t a b l e  
                         / /   T h i s   i s   n e e d e d   t o   e n s u r e   p r o p e r   e x p o r t  
                         i f   ( p a r a m e t e r s [ p a r a m . K e y ]   = =   n u l l )   p a r a m e t e r s [ p a r a m . K e y ]   =   p a r a m . V a l u e . T o S t r i n g ( ) ;  
                 }  
  
                 / /   s e t   a   g l o b a l   f l a g   w h i c h   d e n o t e s   w h e t h e r   t h e   e x p o r t   i s   d o w n l o a d   o r   n o t  
                 / /   t h i s   i s   n e e d e d   i n   m a n y   a   f u n c t i o n s    
                 i s D o w n l o a d   =   p a r a m e t e r s [ " e x p o r t a c t i o n " ] . T o S t r i n g ( ) . T o L o w e r ( )   = =   " d o w n l o a d " ;  
  
  
                 / /   r e t u r n   p a r a m e t e r s  
                 r e t u r n   p a r a m e t e r s ;  
  
  
         }  
  
         / / /   < s u m m a r y >  
         / / /   G e t   E x p o r t   d a t a   f r o m   a n d   b u i l d   t h e   e x p o r t   b i n a r y / o b j c t .  
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " s t r F o r m a t " > ( s t r i n g )   E x p o r t   f o r m a t < / p a r a m >  
         / / /   < p a r a m   n a m e = " s t r e a m " > ( s t r i n g )   E x p o r t   i m a g e   d a t a   i n   F u s i o n C h a r t s   c o m p r e s s e d   f o r m a t < / p a r a m >  
         / / /   < p a r a m   n a m e = " m e t a " > { H a s t a b l e ) I m a g e   m e t a   d a t a   i n   k e y s   " w i d t h " ,   " h e i g t h "   a n d   " b g C o l o r " < / p a r a m >  
         / / /   < r e t u r n s > < / r e t u r n s >  
         p r i v a t e   M e m o r y S t r e a m   e x p o r t P r o c e s s o r ( s t r i n g   s t r F o r m a t ,   s t r i n g   s t r e a m ,   H a s h t a b l e   m e t a )  
         {  
  
                 s t r F o r m a t   =   s t r F o r m a t . T o L o w e r ( ) ;  
                 / /   i n i t i l i z e   m e m e o r y   s t r e a m   o b j e c t   t o   s t o r e   o u t p u t   b y t e s  
                 M e m o r y S t r e a m   e x p o r t O b j e c t S t r e a m   =   n e w   M e m o r y S t r e a m ( ) ;  
  
                 / /   H a n d l e   E x p o r t   c l a s s   a s   p e r   e x p o r t   f o r m a t  
                 s w i t c h   ( s t r F o r m a t )  
                 {  
                         c a s e   " p d f " :  
                                 / /   I n s t a n t i a t e   E x p o r t   c l a s s   f o r   P D F ,   b u i l d   B i n a r y   s t r e a m   a n d   s t o r e   i n   s t r e a m   o b j e c t  
                                 F C P D F G e n e r a t o r   P D F G E N   =   n e w   F C P D F G e n e r a t o r ( s t r e a m ,   m e t a [ " w i d t h " ] . T o S t r i n g ( ) ,   m e t a [ " h e i g h t " ] . T o S t r i n g ( ) ,   m e t a [ " b g c o l o r " ] . T o S t r i n g ( ) ) ;  
                                 e x p o r t O b j e c t S t r e a m   =   P D F G E N . g e t B i n a r y S t r e a m ( s t r F o r m a t ) ;  
                                 b r e a k ;  
                         c a s e   " j p g " :  
                         c a s e   " j p e g " :  
                         c a s e   " p n g " :  
                         c a s e   " g i f " :  
                                 / /   I n s t a n t i a t e   E x p o r t   c l a s s   f o r   I m a g e s ,   b u i l d   B i n a r y   s t r e a m   a n d   s t o r e   i n   s t r e a m   o b j e c t  
                                 F C I M G G e n e r a t o r   I M G G E N   =   n e w   F C I M G G e n e r a t o r ( s t r e a m ,   m e t a [ " w i d t h " ] . T o S t r i n g ( ) ,   m e t a [ " h e i g h t " ] . T o S t r i n g ( ) ,   m e t a [ " b g c o l o r " ] . T o S t r i n g ( ) ) ;  
                                 e x p o r t O b j e c t S t r e a m   =   I M G G E N . g e t B i n a r y S t r e a m ( s t r F o r m a t ) ;  
                                 b r e a k ;  
                         d e f a u l t :  
                                 / /   I n   c a s e   t h e   f o r m a t   i s   n o t   r e c o g n i z e d  
                                 r a i s e _ e r r o r ( "   I n v a l i d   E x p o r t   F o r m a t . " ,   t r u e ) ;  
                                 b r e a k ;  
                 }  
  
                 r e t u r n   e x p o r t O b j e c t S t r e a m ;  
         }  
  
         / / /   < s u m m a r y >  
         / / /   C h e c k s   w h e t h e r   t h e   e x p o r t   a c t i o n   i s   d o w n l o a d   o r   s a v e .  
         / / /   I f   a c t i o n   i s   ' d o w n l o a d ' ,   s e n d   e x p o r t   p a r a m e t e r s   t o   ' s e t u p D o w n l o a d '   f u n c t i o n .  
         / / /   I f   a c t i o n   i s   n o t - ' d o w n l o a d ' ,   s e n d   e x p o r t   p a r a m e t e r s   t o   ' s e t u p S e r v e r '   f u n c t i o n .  
         / / /   I n   e i t h e r   c a s e   i t   g e t s   e x p o r t S e t t i n g s   a n d   p a s s e s   t h e   s e t t i n g s   a l o n g   w i t h    
         / / /   p r o c e s s e d   e x p o r t   b i n a r y   ( i m a g e / P D F )   t o   t h e   o u t p u t   h a n d l e r   f u n c t i o n   i f   t h e  
         / / /   e x p o r t   s e t t i n g s   r e t u r n   a   ' r e a d y '   f l a g   s e t   t o   ' t r u e '   o r   ' d o w n l o a d ' .   T h e   e x p o r t  
         / / /   p r o c e s s   w o u l d   s t o p   h e r e   i f   t h e   a c t i o n   i s   ' d o w n l o a d ' .   I n   t h e   o t h e r   c a s e ,    
         / / /   i t   g e t s   b a c k   s u c c e s s   s t a t u s   f r o m   o u t p u t   h a n d l e r   f u n c t i o n   a n d   r e t u r n s   i t .  
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " e x p o r t O b j " > E x p o r t   b i n a r y / o b j e c t   i n   m e m e r y   s t r e a m < / p a r a m >  
         / / /   < p a r a m   n a m e = " e x p o r t P a r a m s " > H a s h t a b l e   o f   e x p o r t   p a r a m e t e r s < / p a r a m >  
         / / /   < r e t u r n s > E x p o r t   s u c c e s s   s t a t u s   (   f i l e n a m e   i f   s u c c e s s ,   f a l s e   i f   n o t ) < / r e t u r n s >  
         p r i v a t e   o b j e c t   o u t p u t E x p o r t O b j e c t ( M e m o r y S t r e a m   e x p o r t O b j ,   H a s h t a b l e   e x p o r t P a r a m s )  
         {  
                 / / p a s s   e x p o r t   p a r a m t e r s   a n d   g e t   b a c k   e x p o r t   s e t t i n g s   a s   p e r   e x p o r t   a c t i o n  
                 H a s h t a b l e   e x p o r t A c t i o n S e t t i n g s   =   ( i s D o w n l o a d   ?   s e t u p D o w n l o a d ( e x p o r t P a r a m s )   :   s e t u p S e r v e r ( e x p o r t P a r a m s ) ) ;  
  
                 / /   s e t   d e f a u l t   e x p o r t   s t a t u s   t o   t r u e  
                 b o o l   s t a t u s   =   t r u e ;  
  
                 / /   f i l e p a t h   r e t u r n e d   b y   s e r v e r   s e t u p   w o u l d   b e   a   s t r i n g   c o n t a i n i n g   t h e   f i l e   p a t h  
                 / /   w h e r e   t h e   e x p o r t   f i l e   i s   t o   b e   s a v e d .  
                 / /   I f   f i l e p a t h   i s   a   b o o l e a n   ( i . e .   f a l s e )   t h e   s e r v e r   s e t u p   m u s t   h a v e   f a i l e d .   H e n c e ,   t e r m i n a t e   p r o c e s s .  
                 i f   ( e x p o r t A c t i o n S e t t i n g s [ " f i l e p a t h " ]   i s   b o o l )  
                 {  
                         s t a t u s   =   f a l s e ;  
                         r a i s e _ e r r o r ( "   F a i l e d   t o   e x p o r t . " ,   t r u e ) ;  
                 }  
                 e l s e  
                 {  
                         / /   W h e n   ' f i l e p a t h '   i s   a   s t i n g   w r i t e   t h e   b i n a r y   t o   o u t p u t   s t r e a m  
                         t r y  
                         {  
                                 / /   W r i t e   e x p o r t   b i n a r y   s t r e a m   t o   o u t p u t   s t r e a m  
                                 S t r e a m   o u t S t r e a m   =   ( S t r e a m ) e x p o r t A c t i o n S e t t i n g s [ " o u t S t r e a m " ] ;  
                                 e x p o r t O b j . W r i t e T o ( o u t S t r e a m ) ;  
                                 o u t S t r e a m . F l u s h ( ) ;  
                                 o u t S t r e a m . C l o s e ( ) ;  
                                 e x p o r t O b j . C l o s e ( ) ;  
                         }  
                         c a t c h   ( A r g u m e n t N u l l E x c e p t i o n   e )  
                         {  
                                 r a i s e _ e r r o r ( "   F a i l e d   t o   e x p o r t .   E r r o r : "   +   e . M e s s a g e ) ;  
                                 s t a t u s   =   f a l s e ;  
                         }  
                         c a t c h   ( O b j e c t D i s p o s e d E x c e p t i o n   e )  
                         {  
                                 r a i s e _ e r r o r ( "   F a i l e d   t o   e x p o r t .   E r r o r : "   +   e . M e s s a g e ) ;  
                                 s t a t u s   =   f a l s e ;  
                         }  
  
                          
                         i f   ( i s D o w n l o a d )  
                         {  
                                 / /   I f   ' d o w n l o a d ' -   t e r m i n a t e   i m e d i a t e l y  
                                 / /   A s   n o t h i n g   i s   t o   b e   w r i t t e n   t o   r e s p o n s e   n o w .  
                                 R e s p o n s e . E n d ( ) ;  
                         }  
  
                 }  
  
                 / /   T h i s   i s   t h e   r e s p o n s e   a f t e r   s a v e   a c t i o n  
                 / /   I f   s t a t u s   r e m a i n s   t r u e   r e t u r n   t h e   ' f i l e p a t h ' .   O t h e r w i s e   r e t u r n   f a l s e   t o   d e n o t e   f a i l u r e .  
                 r e t u r n   ( s t a t u s   ?   e x p o r t A c t i o n S e t t i n g s [ " f i l e p a t h " ]   :   f a l s e ) ;  
  
  
         }  
         / / /   < s u m m a r y >  
         / / /   F l u s h e s   e x p o r t e d   s t a t u s   m e s s a g e / o r   a n y   s t a t u s   m e s s a g e   t o   t h e   c h a r t   o r   t h e   o u t p u t   s t r e a m .  
         / / /   I t   p a r s e s   t h e   e x p o r t e d   s t a t u s   t h r o u g h   p a r s e r   f u n c t i o n   p a r s e E x p o r t e d S t a t u s ,  
         / / /   b u i l d s   p r o p e r   r e s p o n s e   s t r i n g   u s i n g   b u i l d R e s p o n s e   f u n c t i o n   a n d   f l u s h e s   t h e   r e s p o n s e  
         / / /   s t r i n g   t o   t h e   o u t p u t   s t r e a m   a n d   t e r m i n a t e s   t h e   p r o g r a m .  
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " f i l e n a m e " > N a m e   o f   t h e   e x p o r t e d   f i l e   o r   f a l s e   o n   f a i l u r e < / p a r a m >  
         / / /   < p a r a m   n a m e = " m e t a " > I m a g e ' s   m e t a   d a t a < / p a r a m >  
         / / /   < p a r a m   n a m e = " m s g " > A d d i t i o n a l   m e s s a g e s < / p a r a m >  
         p r i v a t e   v o i d   f l u s h S t a t u s ( o b j e c t   f i l e n a m e ,   H a s h t a b l e   m e t a ,   s t r i n g   m s g )  
         {  
                 / /   P r o c e s s   a n d   f l u s h   m e s s a g e   t o   r e s p o n s e   s t r e a m   a n d   t e r m i n a t e  
                 R e s p o n s e . O u t p u t . W r i t e ( b u i l d R e s p o n s e ( p a r s e E x p o r t e d S t a t u s ( f i l e n a m e ,   m e t a ,   m s g ) ) ) ;  
                 R e s p o n s e . F l u s h ( ) ;  
                 R e s p o n s e . E n d ( ) ;  
         }  
  
         / / /   < s u m m a r y >  
         / / /   F l u s h e s   e x p o r t e d   s t a t u s   m e s s a g e / o r   a n y   s t a t u s   m e s s a g e   t o   t h e   c h a r t   o r   t h e   o u t p u t   s t r e a m .  
         / / /   I t   p a r s e s   t h e   e x p o r t e d   s t a t u s   t h r o u g h   p a r s e r   f u n c t i o n   p a r s e E x p o r t e d S t a t u s ,  
         / / /   b u i l d s   p r o p e r   r e s p o n s e   s t r i n g   u s i n g   b u i l d R e s p o n s e   f u n c t i o n   a n d   f l u s h e s   t h e   r e s p o n s e  
         / / /   s t r i n g   t o   t h e   o u t p u t   s t r e a m   a n d   t e r m i n a t e s   t h e   p r o g r a m .  
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " f i l e n a m e " > N a m e   o f   t h e   e x p o r t e d   f i l e   o r   f a l s e   o n   f a i l u r e < / p a r a m >  
         / / /   < p a r a m   n a m e = " m e t a " > I m a g e ' s   m e t a   d a t a < / p a r a m >  
         / / /   < p a r a m   n a m e = " m e t a " > < / p a r a m >  
         p r i v a t e   v o i d   f l u s h S t a t u s ( o b j e c t   f i l e n a m e ,   H a s h t a b l e   m e t a )  
         {  
                 f l u s h S t a t u s ( f i l e n a m e ,   m e t a ,   " " ) ;  
         }  
  
  
         / / /   < s u m m a r y >  
         / / /   P a r s e s   t h e   e x p o r t e d   s t a t u s   a n d   b u i l d s   a n   a r r a y   o f   e x p o r t   s t a t u s   i n f o r m a t i o n .   A s   p e r  
         / / /   s t a t u s   i t   b u i l d s   a   s t a t u s   a r r a y   w h i c h   c o n t a i n s   s t a t u s C o d e   ( 0 / 1 ) ,   s t a t u s M e s a g e ,   f i l e N a m e ,  
         / / /   w i d t h ,   h e i g h t   a n d   n o t i c e   i n   s o m e   c a s e s .  
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " f i l e n a m e " > e x p o r t e d   s t a t u s   (   f a l s e   i f   f a i l e d / e r r o r ,   f i l e n a m e   a s   s t i r n g   i f   s u c c e s s ) < / p a r a m >  
         / / /   < p a r a m   n a m e = " m e t a " > H a s t a b l e   c o n t a i n i n g   m e t a   d e s c r i p t i o n s   o f   t h e   c h a r t   l i k e   w i d t h ,   h e i g h t < / p a r a m >  
         / / /   < p a r a m   n a m e = " m s g " > c u s t o m   m e s s a g e   t o   b e   a d d e d   a s   s t a t u s M e s s a g e . < / p a r a m >  
         / / /   < r e t u r n s > < / r e t u r n s >  
         p r i v a t e   A r r a y L i s t   p a r s e E x p o r t e d S t a t u s ( o b j e c t   f i l e n a m e ,   H a s h t a b l e   m e t a ,   s t r i n g   m s g )  
         {  
  
                 A r r a y L i s t   a r r S t a t u s   =   n e w   A r r a y L i s t ( ) ;  
                 / /   g e t   s t a t u s  
                 b o o l   s t a t u s   =   ( f i l e n a m e   i s   s t r i n g   ?   t r u e   :   f a l s e ) ;  
  
                 / /   a d d   n o t i c e s    
                 i f   ( n o t i c e s . T r i m ( )   ! =   " " )   a r r S t a t u s . A d d ( " n o t i c e = "   +   n o t i c e s . T r i m ( ) ) ;  
  
                 / /   D O M I d   o f   t h e   c h a r t  
                 a r r S t a t u s . A d d ( " D O M I d = "   +   ( m e t a [ " D O M I d " ] = = n u l l ?   D O M I d   :   m e t a [ " D O M I d " ] . T o S t r i n g ( ) ) ) ;  
                  
                 / /   a d d   w i d t h   a n d   h e i g h t  
                 / /   p r o v i d e   0   a s   w i d t h   a n d   h e i g h t   o n   f a i l u r e 	  
                 i f   ( m e t a [ " w i d t h " ]   = =   n u l l )   m e t a [ " w i d t h " ]   =   " 0 " ;  
                 i f   ( m e t a [ " h e i g h t " ]   = =   n u l l )   m e t a [ " h e i g h t " ]   =   " 0 " ;  
                 a r r S t a t u s . A d d ( " h e i g h t = "   +   ( s t a t u s   ?   m e t a [ " h e i g h t " ] . T o S t r i n g ( )   :   " 0 " ) ) ;  
                 a r r S t a t u s . A d d ( " w i d t h = "   +   ( s t a t u s   ?   m e t a [ " w i d t h " ] . T o S t r i n g ( )   :   " 0 " ) ) ;  
  
                 / /   a d d   f i l e   U R I  
                 a r r S t a t u s . A d d ( " f i l e N a m e = "   +   ( s t a t u s   ?   ( R e g e x . R e p l a c e ( H T T P _ U R I ,   @ " ( [ ^ \ / ] $ ) " ,   " $ { 1 } / " )   +   f i l e n a m e )   :   " " ) ) ;  
                 a r r S t a t u s . A d d ( " s t a t u s M e s s a g e = "   +   ( m s g . T r i m ( )   ! =   " "   ?   m s g . T r i m ( )   :   ( s t a t u s   ?   " S u c c e s s "   :   " F a i l u r e " ) ) ) ;  
                 a r r S t a t u s . A d d ( " s t a t u s C o d e = "   +   ( s t a t u s   ?   " 1 "   :   " 0 " ) ) ;  
  
                 r e t u r n   a r r S t a t u s ;  
  
         }  
  
  
         / / /   < s u m m a r y >  
         / / /   B u i l d s   r e s p o n s e   f r o m   a n   a r r a y   o f   s t a t u s   i n f o r m a t i o n .   J o i n s   t h e   a r r a y   t o   a   s t r i n g .  
         / / /   E a c h   a r r a y   e l e m e n t   s h o u l d   b e   a   s t r i n g   w h i c h   i s   a   k e y = v a l u e   p a i r .   T h i s   a r r a y   a r e   e i t h e r   j o i n e d   b y    
         / / /   a   &   t o   b u i l d   a   q u e r y s t r i n g   ( t o   p a s s   t o   c h a r t )   o r   j o i n e d   b y   a   H T M L   < B R >   t o   s h o w   n e a t  
         / / /   a n d   c l e a n   s t a t u s   i n f o r m a t o n   i n   B r o w s e r   w i n d o w   i f   d o w n l o a d   f a i l s   a t   t h e   p r o c e s s i n g   s t a g e .    
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " a r r M s g " > A r r a y   o f   s t r i n g   c o n t a i n i n g   s t a t u s   d a t a   a s   [ k e y = v a l u e   ] < / p a r a m >  
         / / /   < r e t u r n s > A   s t r i n g   t o   b e   w r i t t e n   t o   o u t p u t   s t r e a m < / r e t u r n s >  
         p r i v a t e   s t r i n g   b u i l d R e s p o n s e ( A r r a y L i s t   a r r M s g )  
         {  
                 / /   J o i n   e x p o r t   s t a t u s   a r r a y   e l e m e n t s   i n t o   q u e r y s t r i n g   k e y - v a l u e   p a i r s   i n   c a s e   o f   ' s a v e '   a c t i o n  
                 / /   o r   s e p a r a t e   w i t h   < B R >   i n   c a s e   o f   ' d o w n l o a d '   a c t i o n .   T h i s   w o u l d   m a k e   t h e   i m f o r m a t i o n   r e a d a b l e   i n   b r o w s e r   w i n d o w .  
                 s t r i n g   m s g   =   i s D o w n l o a d   ?   " "   :   " & " ;  
                 m s g   + =   s t r i n g . J o i n ( ( i s D o w n l o a d   ?   " < b r > "   :   " & " ) ,   ( s t r i n g [ ] ) a r r M s g . T o A r r a y ( t y p e o f ( s t r i n g ) ) ) ;  
                 r e t u r n   m s g ;  
         }  
  
         / / /   < s u m m a r y >  
         / / /   F i n d s   i f   a   d i r e c t o r y   i s   w r i t a b l e  
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " p a t h " > S t r i n g   P a t h < / p a r a m >  
         / / /   < r e t u r n s > < / r e t u r n s >  
         p r i v a t e   b o o l   i s D i r e c t o r y W r i t a b l e ( s t r i n g   p a t h )  
         {  
                 D i r e c t o r y I n f o   i n f o   =   n e w   D i r e c t o r y I n f o ( p a t h ) ;  
                 r e t u r n   ( i n f o . A t t r i b u t e s   &   F i l e A t t r i b u t e s . R e a d O n l y )   ! =   F i l e A t t r i b u t e s . R e a d O n l y ;  
  
         }  
         / / /   < s u m m a r y >  
         / / /   c h e c k   s e r v e r   p e r m i s s i o n s   a n d   s e t t i n g s   a n d   r e t u r n   r e a d y   f l a g   t o   e x p o r t S e t t i n g s    
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " e x p o r t P a r a m s " > V a r i o u s   e x p o r t   p a r a m e t e r s < / p a r a m >  
         / / /   < r e t u r n s > H a s h t a b l e   c o n t a i n i n g   v a r i o u s   e x p o r t   s e t t i n g s < / r e t u r n s >  
         p r i v a t e   H a s h t a b l e   s e t u p S e r v e r ( H a s h t a b l e   e x p o r t P a r a m s )  
         {  
  
                 / / g e t   e x p o r t   f i l e   n a m e  
                 s t r i n g   e x p o r t F i l e   =   e x p o r t P a r a m s [ " e x p o r t f i l e n a m e " ] . T o S t r i n g ( ) ;  
                 / /   g e t   e x t e n s i o n   r e l a t e d   t o   s p e c i f i e d   t y p e    
                 s t r i n g   e x t   =   g e t E x t e n s i o n ( e x p o r t P a r a m s [ " e x p o r t f o r m a t " ] . T o S t r i n g ( ) ) ;  
  
                 H a s h t a b l e   r e t S e r v e r S t a t u s   =   n e w   H a s h t a b l e ( ) ;  
                  
                 / / s e t   s e r v e r   s t a t u s   t o   t r u e   b y   d e f a u l t  
                 r e t S e r v e r S t a t u s [ " r e a d y " ]   =   t r u e ;  
  
                 / /   O p e n   a   F i l e S t r e a m   t o   b e   u s e d   a s   o u t p u r   s t r e a m   w h e n   t h e   f i l e   w o u l d   b e   s a v e d  
                 F i l e S t r e a m   f o s ;  
  
                 / /   p r o c e s s   S A V E _ P A T H   :   t h e   p a t h   w h e r e   e x p o r t   f i l e   w o u l d   b e   s a v e d  
                 / /   a d d   a   /   a t   t h e   e n d   o f   p a t h   i f   /   i s   a b s e n t   a t   t h e   e n d  
  
                 s t r i n g   p a t h   =   S A V E _ P A T H ;  
                 / /   i f   p a t h   i s   n u l l   s e t   i t   t o   f o l d e r   w h e r e   F C E x p o r t e r . a s p x   i s   p r e s e n t  
                 i f   ( p a t h . T r i m ( )   = =   " " )   p a t h   =   " . / " ;  
                 p a t h   =   R e g e x . R e p l a c e ( p a t h ,   @ " ( [ ^ \ / ] $ ) " ,   " $ { 1 } / " ) ;  
  
                 t r y  
                 {  
                         / /   c h e c k   i f   t h e   p a t h   i s   r e l a t i v e   i f   s o   a s s i g n   t h e   a c t u a l   p a t h   t o   p a t h  
                         p a t h   =   H t t p C o n t e x t . C u r r e n t . S e r v e r . M a p P a t h ( p a t h ) ;  
                 }  
                 c a t c h   ( H t t p E x c e p t i o n   e )  
                 {  
                         / / r a i s e _ e r r o r ( e . M e s s a g e ) ;  
                 }  
  
  
                 / /   c h e c k   w h e t h e r   d i r e c t o r y   e x i s t s  
                 / /   r a i s e   e r r o r   a n d   h a l t   e x e c u t i o n   i f   d i r e c t o r y   d o e s   n o t   e x i s t s  
                 i f   ( ! D i r e c t o r y . E x i s t s ( p a t h ) )   r a i s e _ e r r o r ( "   S e r v e r   D i r e c t o r y   d o e s   n o t   e x i s t . " ,   t r u e ) ;  
  
                 / /   c h e c k   i f   d i r e c t o r y   i s   w r i t a b l e   o r   n o t  
                 b o o l   d i r W r i t a b l e   =   i s D i r e c t o r y W r i t a b l e ( p a t h ) ;  
  
                 / /   b u i l d   f i l e p a t h  
                 r e t S e r v e r S t a t u s [ " f i l e p a t h " ]   =   e x p o r t F i l e   +   " . "   +   e x t ;  
  
                 / /   c h e c k   w h e t h e r   f i l e   e x i s t s  
                 i f   ( ! F i l e . E x i s t s ( p a t h   +   r e t S e r v e r S t a t u s [ " f i l e p a t h " ] . T o S t r i n g ( ) ) )  
                 {  
                         / /   n e e d   t o   c r e a t e   a   n e w   f i l e   i f   d o e s   n o t   e x i s t s  
                         / /   n e e d   t o   c h e c k   w h e t h e r   t h e   d i r e c t o r y   i s   w r i t a b l e   t o   c r e a t e   a   n e w   f i l e      
                         i f   ( d i r W r i t a b l e )  
                         {  
                                 / /   i f   d i r e c t o r y   i s   w r i t a b l e   r e t u r n   w i t h   r e a d y   f l a g  
  
                                 / /   o p e n   t h e   o u t p u t   f i l e   i n   F i l e S t r e a m  
                                 f o s   =   F i l e . O p e n ( p a t h   +   r e t S e r v e r S t a t u s [ " f i l e p a t h " ] . T o S t r i n g ( ) ,   F i l e M o d e . C r e a t e ,   F i l e A c c e s s . W r i t e ) ;  
  
                                 / /   s e t   t h e   o u t p u t   s t r e a m   t o   t h e   F i l e S t r e a m   o b j e c t  
                                 r e t S e r v e r S t a t u s [ " o u t S t r e a m " ]   =   f o s ;  
                                 r e t u r n   r e t S e r v e r S t a t u s ;  
                         }  
                         e l s e  
                         {  
                                 / /   i f   n o t   w r i t a b l e   h a l t   a n d   r a i s e   e r r o r  
                                 r a i s e _ e r r o r ( " 4 0 3 " ,   t r u e ) ;  
                         }  
                 }  
  
                 / /   a d d   n o t i c e   t h a t   f i l e   e x i s t s    
                 r a i s e _ e r r o r ( "   F i l e   a l r e a d y   e x i s t s . " ) ;  
  
                 / / i f   o v e r w r i t e   i s   o n   r e t u r n   w i t h   r e a d y   f l a g    
                 i f   ( O V E R W R I T E F I L E )  
                 {  
                         / /   a d d   n o t i c e   w h i l e   t r y i n g   t o   o v e r w r i t e  
                         r a i s e _ e r r o r ( "   E x p o r t   h a n d l e r ' s   O v e r w r i t e   s e t t i n g   i s   o n .   T r y i n g   t o   o v e r w r i t e . " ) ;  
  
                         / /   s e e   w h e t h e r   t h e   e x i s t i n g   f i l e   i s   w r i t a b l e  
                         / /   i f   n o t   h a l t   r a i s i n g   e r r o r   m e s s a g e  
                         i f   ( ( n e w   F i l e I n f o ( p a t h   +   r e t S e r v e r S t a t u s [ " f i l e p a t h " ] . T o S t r i n g ( ) ) ) . I s R e a d O n l y )  
                                 r a i s e _ e r r o r ( "   O v e r w r i t e   f o r b i d d e n .   F i l e   c a n n o t   b e   o v e r w r i t t e n . " ,   t r u e ) ;  
  
                         / /   i f   w r i t a b l e   r e t u r n   w i t h   r e a d y   f l a g    
                         / /   o p e n   t h e   o u t p u t   f i l e   i n   F i l e S t r e a m  
                         / /   s e t   t h e   o u t p u t   s t r e a m   t o   t h e   F i l e S t r e a m   o b j e c t  
                         f o s   =   F i l e . O p e n ( p a t h   +   r e t S e r v e r S t a t u s [ " f i l e p a t h " ] . T o S t r i n g ( ) ,   F i l e M o d e . C r e a t e ,   F i l e A c c e s s . W r i t e ) ;  
                         r e t S e r v e r S t a t u s [ " o u t S t r e a m " ]   =   f o s ;  
                         r e t u r n   r e t S e r v e r S t a t u s ;  
                 }  
  
                 / /   r a i s e   e r r o r   a n d   h a l t   e x e c u t i o n   w h e n   o v e r w r i t e   i s   o f f   a n d   i n t e l l i g e n t   n a m i n g   i s   o f f    
                 i f   ( ! I N T E L L I G E N T F I L E N A M I N G )  
                 {  
                         r a i s e _ e r r o r ( "   E x p o r t   h a n d l e r ' s   O v e r w r i t e   s e t t i n g   i s   o f f .   C a n n o t   o v e r w r i t e . " ,   t r u e ) ;  
                 }  
  
                 r a i s e _ e r r o r ( "   U s i n g   i n t e l l i g e n t   n a m i n g   o f   f i l e   b y   a d d i n g   a n   u n i q u e   s u f f i x   t o   t h e   e x i s i n g   n a m e . " ) ;  
                 / /   I n t e l l i g e n t   n a m i n g    
                 / /   g e n e r a t e   n e w   f i l e n a m e   w i t h   a d d i t i o n a l   s u f f i x  
                 e x p o r t F i l e   =   e x p o r t F i l e   +   " _ "   +   g e n e r a t e I n t e l l i g e n t F i l e I d ( ) ;  
                 r e t S e r v e r S t a t u s [ " f i l e p a t h " ]   =   e x p o r t F i l e   +   " . "   +   e x t ;  
  
                 / /   r e t u r n   i n t e l l i g e n t   f i l e   n a m e   w i t h   r e a d y   f l a g  
                 / /   n e e d   t o   c h e c k   w h e t h e r   t h e   d i r e c t o r y   i s   w r i t a b l e   t o   c r e a t e   a   n e w   f i l e      
                 i f   ( d i r W r i t a b l e )  
                 {  
                         / /   i f   d i r e c t o r y   i s   w r i t a b l e   r e t u r n   w i t h   r e a d y   f l a g  
                         / /   a d d   n e w   f i l e n a m e   n o t i c e  
                         / /   o p e n   t h e   o u t p u t   f i l e   i n   F i l e S t r e a m  
                         / /   s e t   t h e   o u t p u t   s t r e a m   t o   t h e   F i l e S t r e a m   o b j e c t  
                         r a i s e _ e r r o r ( "   T h e   f i l e n a m e   h a s   c h a n g e d   t o   "   +   r e t S e r v e r S t a t u s [ " f i l e p a t h " ] . T o S t r i n g ( )   +   " . " ) ;  
                         f o s   =   F i l e . O p e n ( p a t h   +   r e t S e r v e r S t a t u s [ " f i l e p a t h " ] . T o S t r i n g ( ) ,   F i l e M o d e . C r e a t e ,   F i l e A c c e s s . W r i t e ) ;  
  
                         / /   s e t   t h e   o u t p u t   s t r e a m   t o   t h e   F i l e S t r e a m   o b j e c t  
                         r e t S e r v e r S t a t u s [ " o u t S t r e a m " ]   =   f o s ;  
                         r e t u r n   r e t S e r v e r S t a t u s ;  
                 }  
                 e l s e  
                 {  
                         / /   i f   n o t   w r i t a b l e   h a l t   a n d   r a i s e   e r r o r  
                         r a i s e _ e r r o r ( " 4 0 3 " ,   t r u e ) ;  
                 }  
  
                 / /   i n   a n y   u n k n o w n   c a s e   t h e   e x p o r t   s h o u l d   n o t   e x e c u t e 	  
                 r e t S e r v e r S t a t u s [ " r e a d y " ]   =   f a l s e ;  
                 r a i s e _ e r r o r ( "   N o t   e x p o r t e d   d u e   t o   u n k n o w n   r e a s o n s . " ) ;  
                 r e t u r n   r e t S e r v e r S t a t u s ;  
  
         }  
         / / /   < s u m m a r y >  
         / / /   s e t u p   d o w n l o a d   h e a d e r s   a n d   r e t u r n   r e a d y   f l a g   i n   e x p o r t S e t t i n g s    
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " e x p o r t P a r a m s " > V a r i o u s   e x p o r t   p a r a m e t e r s < / p a r a m >  
         / / /   < r e t u r n s > H a s h t a b l e   c o n t a i n i n g   v a r i o u s   e x p o r t   s e t t i n g s < / r e t u r n s >  
         p r i v a t e   H a s h t a b l e   s e t u p D o w n l o a d ( H a s h t a b l e   e x p o r t P a r a m s )  
         {  
                  
                 / / g e t   e x p o r t   f i l e n a m e  
                 s t r i n g   e x p o r t F i l e   =   e x p o r t P a r a m s [ " e x p o r t f i l e n a m e " ] . T o S t r i n g ( ) ;  
                 / / g e t   e x t e n s i o n  
                 s t r i n g   e x t   =   g e t E x t e n s i o n ( e x p o r t P a r a m s [ " e x p o r t f o r m a t " ] . T o S t r i n g ( ) ) ;  
                 / / g e t   m i m e   t y p e  
                 s t r i n g   m i m e   =   g e t M i m e ( e x p o r t P a r a m s [ " e x p o r t f o r m a t " ] . T o S t r i n g ( ) ) ;  
                 / /   g e t   t a r g e t   w i n d o w  
                 s t r i n g   t a r g e t   =   e x p o r t P a r a m s [ " e x p o r t t a r g e t w i n d o w " ] . T o S t r i n g ( ) . T o L o w e r ( ) ;  
  
                 / /   s e t   c o n t e n t - t y p e   h e a d e r    
                 R e s p o n s e . C o n t e n t T y p e   =   m i m e ;  
  
                 / /   s e t   c o n t e n t - d i s p o s i t i o n   h e a d e r    
                 / /   w h e n   t a r g e t   i s   _ s e l f   t h e   t y p e   i s   ' a t t a c h m e n t '  
                 / /   w h e n   t a r g e t   i s   o t h e r   t h a n   s e l f   t y p e   i s   ' i n l i n e '  
                 / /   N O T E   :   y o u   c a n   c o m m e n t   t h i s   l i n e   i n   o r d e r   t o   r e p l a c e   p r e s e n t   w i n d o w   ( _ s e l f )   c o n t e n t   w i t h   t h e   i m a g e / P D F      
                 R e s p o n s e . A d d H e a d e r ( " C o n t e n t - D i s p o s i t i o n " ,   ( t a r g e t   = =   " _ s e l f "   ?   " a t t a c h m e n t "   :   " i n l i n e " )   +   " ;   f i l e n a m e = \ " "   +   e x p o r t F i l e   +   " . "   +   e x t   +   " \ " " ) ;  
  
                 / /   r e t u r n   e x p o r t S e t t i n g   a r r a y .   ' R e a d y '   k e y   s h o u l d   b e   s e t   t o   ' d o w n l o a d '  
                 H a s h t a b l e   r e t S t a t u s   =   n e w   H a s h t a b l e ( ) ;  
                 r e t S t a t u s [ " f i l e p a t h " ]   =   " " ;  
  
                 / /   s e t   t h e   o u t p u t   s t r e m   t o   R e s p o n s e   s t r e a m   a s   t h e   f i l e   i s   g o i n g   t o   b e   d o w n l o a d e d  
                 r e t S t a t u s [ " o u t S t r e a m " ]   =   R e s p o n s e . O u t p u t S t r e a m ;  
                 r e t u r n   r e t S t a t u s ;  
  
         }  
  
         / / /   < s u m m a r y >  
         / / /     g e t s   f i l e   e x t e n s i o n   c h e c k i n g   t h e   e x p o r t   t y p e .    
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " e x p o r t T y p e " > ( s t r i n g )   e x p o r t   f o r m a t < / p a r a m >  
         / / /   < r e t u r n s > s t r i n g   e x t e n s i o n   n a m e < / r e t u r n s >  
         p r i v a t e   s t r i n g   g e t E x t e n s i o n ( s t r i n g   e x p o r t T y p e )  
         {  
                 / /   g e t   a   H a s h t a b l e   a r r a y   o f   [ t y p e = >   e x t e n s i o n ]    
                 / /   f r o m   E X T E N S I O N S   c o n s t a n t    
                 H a s h t a b l e   e x t e n s i o n L i s t   =   b a n g ( E X T E N S I O N S ) ;  
                 e x p o r t T y p e   =   e x p o r t T y p e . T o L o w e r ( ) ;  
  
                 / /   i f   e x t e n s i o n   t y p e   i s   p r e s e n t   i n   $ e x t e n s i o n L i s t   r e t u r n   i t ,   o t h e r w i s e   r e t u r n   t h e   t y p e    
                 r e t u r n   ( e x t e n s i o n L i s t [ e x p o r t T y p e ] . T o S t r i n g ( )   ! =   n u l l   ?   e x t e n s i o n L i s t [ e x p o r t T y p e ] . T o S t r i n g ( )   :   e x p o r t T y p e ) ;  
         }  
         / / /   < s u m m a r y >  
         / / /   g e t s   m i m e   t y p e   f o r   a n   e x p o r t   t y p e  
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " e x p o r t T y p e " > E x p o r t   f o r m a t < / p a r a m >  
         / / /   < r e t u r n s > M i m e   t y p e   a s   s t i r n g < / r e t u r n s >  
         p r i v a t e   s t r i n g   g e t M i m e ( s t r i n g   e x p o r t T y p e )  
         {  
                 / /   g e t   a   H a s h t a b l e   a r r a y   o f   [ t y p e = >   e x t e n s i o n ]    
                 / /   f r o m   M I M E T Y P E S   c o n s t a n t    
                 H a s h t a b l e   m i m e l i s t   =   b a n g ( M I M E T Y P E S ) ;  
                 s t r i n g   e x t   =   g e t E x t e n s i o n ( e x p o r t T y p e ) ;  
  
                 / /   g e t   m i m e   t y p e   a s o c i a t e d   t o   e x t e n s i o n  
                 s t r i n g   m i m e   =   m i m e l i s t [ e x t ] . T o S t r i n g ( )   ! =   n u l l   ?   m i m e l i s t [ e x t ] . T o S t r i n g ( )   :   " " ;  
                 r e t u r n   m i m e ;  
         }  
  
         / / /   < s u m m a r y >  
         / / /   g e n e r a t e s   a   f i l e   s u f f i x   f o r   a   e x i s t i n g   f i l e   n a m e   t o   a p p l y   s m a r t   f i l e   n a m i n g    
         / / /   < / s u m m a r y >  
         / / /   < r e t u r n s > a   s t r i n g   c o n t a i n i n g   G U I D   a n d   r a n d o m   n u m b e r   / t i m e s t a m p < / r e t u r n s >  
         p r i v a t e   s t r i n g   g e n e r a t e I n t e l l i g e n t F i l e I d ( )  
         {  
                 / /   G e n e r a t e   G u i d  
                 s t r i n g   g u i d   =   S y s t e m . G u i d . N e w G u i d ( ) . T o S t r i n g ( " D " ) ;  
  
                 / /   c h e c k   F I L E S U F F I X F O R M A T   t y p e    
                 i f   ( F I L E S U F F I X F O R M A T . T o L o w e r ( )   = =   " t i m e s t a m p " )  
                 {  
                         / /   A d d   t i m e   s t a m p   w i t h   f i l e   n a m e  
                         g u i d   + =   " _ "   +   D a t e T i m e . N o w . T o S t r i n g ( " d d M M y y y y H H m m s s f f " ) ;  
                 }  
                 e l s e  
                 {  
                         / /   A d d   R a n d o m   N u m b e r   w i t h   f i l e N a m e  
                         g u i d   + =   " _ "   +   ( n e w   R a n d o m ( ) ) . N e x t ( ) . T o S t r i n g ( ) ;  
                 }  
  
                 r e t u r n   g u i d ;  
         }  
  
  
         / / /   < s u m m a r y >  
         / / /   H e l p e r   f u n c t i o n   t h a t   s p l i t s   a   s t r i n g   c o n t a i n i n g   d e l i m i t e r   s e p a r a t e d   k e y   v a l u e   p a i r s    
         / / /   i n t o   h a s h t a b l e  
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " s t r " > d e l i m i t e r   s e p a r a t e d   k e y   v a l u e   p a i r s < / p a r a m >  
         / / /   < p a r a m   n a m e = " d e l i m i t e r L i s t " > L i s t   o f   d e l i m i t e r s < / p a r a m >  
         / / /   < r e t u r n s > < / r e t u r n s >  
         p r i v a t e   H a s h t a b l e   b a n g ( s t r i n g   s t r ,   c h a r [ ]   d e l i m i t e r L i s t )  
         {  
                 H a s h t a b l e   r e t A r r a y   =   n e w   H a s h t a b l e ( ) ;  
                 / /   s p l i t   s t r i n g   a s   p e r   f i r s t   d e l i m i t e r  
                 i f   ( s t r   = =   n u l l   | |   s t r . T r i m ( )   = =   " " )   r e t u r n   r e t A r r a y ;  
                 s t r i n g [ ]   t m p A r r a y   =   s t r . S p l i t ( d e l i m i t e r L i s t [ 0 ] ) ;  
  
  
                 / /   i t e r a t e   t h r o u g h   e a c h   e l e m e n t   o f   s p l i t   s t r i n g  
                 f o r   ( i n t   i   =   0 ;   i   <   t m p A r r a y . L e n g t h ;   i + + )  
                 {  
                         / /   s p l i t   e a c h   e l e m e n t   a s   p e r   s e c o n d   d e l i m i t e r  
                         s t r i n g [ ]   t m p 2 A r r a y   =   t m p A r r a y [ i ] . S p l i t ( d e l i m i t e r L i s t [ 1 ] ) ;  
  
                         i f   ( t m p 2 A r r a y . L e n g t h   > =   2 )  
                         {  
                                 / /   i f   t h e   s e c o n d a r y   s p l i t   c r e a t s   a t - l e a s t   2   a r r a y   e l e m e n t s  
                                 / /   m a k e   t h e   f i s r t   e l e m e n t   a s   t h e   k e y   a n d   t h e   s e c o n d   a s   t h e   v a l u e  
                                 / /   o f   t h e   r e s u l t i n g   a r r a y  
                                 r e t A r r a y [ t m p 2 A r r a y [ 0 ] . T o L o w e r ( ) ]   =   t m p 2 A r r a y [ 1 ] ;  
                         }  
                 }  
                 r e t u r n   r e t A r r a y ;  
  
         }  
         p r i v a t e   H a s h t a b l e   b a n g ( s t r i n g   s t r )  
         {  
                 r e t u r n   b a n g ( s t r ,   n e w   c h a r [ 2 ]   {   ' ; ' ,   ' = '   } ) ;  
         }  
         p r i v a t e   v o i d   r a i s e _ e r r o r ( s t r i n g   m s g )  
         {  
                 r a i s e _ e r r o r ( m s g ,   f a l s e ) ;  
         }  
         / / /   < s u m m a r y >  
         / / /   E r r o r   r e p o r t e r   f u n c t i o n   t h a t   h a s   a   l i s t   o f   e r r o r   m e s s a g e s .   I t   c a n   t e r m i n a t e   t h e   e x e c u t i o n  
         / / /   a n d   s e n d   s u c c e s s S t a t u s = 0   a l o n g   w i t h   a   e r r o r   m e s s a g e .   I t   c a n   a l s o   a p p e n d   n o t i c e   t o   a   g l o b a l   v a r i a b l e  
         / / /   a n d   c o n t i n u e   e x e c u t i o n   o f   t h e   p r o g r a m .    
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " m s g " > e r r o r   c o d e   a s   I n t e g e r   ( r e f e r r i n g   t o   t h e   i n d e x   o f   t h e   e r r M e s s a g e s  
         / / /   a r r a y   c o n t a i n i n g   l i s t   o f   e r r o r   m e s s a g e s )   O R ,   i t   c a n   b e   a   s t r i n g   c o n t a i n i n g   t h e   e r r o r   m e s s a g e / n o t i c e < / p a r a m >  
         / / /   < p a r a m   n a m e = " h a l t " > W h e t h e r   t o   h a l t   e x e c u t i o n < / p a r a m >  
         p r i v a t e   v o i d   r a i s e _ e r r o r ( s t r i n g   m s g ,   b o o l   h a l t )  
         {  
                 H a s h t a b l e   e r r M e s s a g e s   =   n e w   H a s h t a b l e ( ) ;  
  
                 / / l i s t   o f   d e f i n e d   e r r o r   m e s s a g e s  
                 e r r M e s s a g e s [ " 1 0 0 " ]   =   "   I n s u f f i c i e n t   d a t a . " ;  
                 e r r M e s s a g e s [ " 1 0 1 " ]   =   "   W i d t h / h e i g h t   n o t   p r o v i d e d . " ;  
                 e r r M e s s a g e s [ " 1 0 2 " ]   =   "   I n s u f f i c i e n t   e x p o r t   p a r a m e t e r s . " ;  
                 e r r M e s s a g e s [ " 4 0 0 " ]   =   "   B a d   r e q u e s t . " ;  
                 e r r M e s s a g e s [ " 4 0 1 " ]   =   "   U n a u t h o r i z e d   a c c e s s . " ;  
                 e r r M e s s a g e s [ " 4 0 3 " ]   =   "   D i r e c t o r y   w r i t e   a c c e s s   f o r b i d d e n . " ;  
                 e r r M e s s a g e s [ " 4 0 4 " ]   =   "   E x p o r t   R e s o u r c e   c l a s s   n o t   f o u n d . " ;  
  
                 / /   F i n d   w h e t h e r   e r r o r   m e s s a g e   i s   p a s s e d   i n   m s g   o r   i t   i s   a   c u s t o m   e r r o r   s t r i n g .  
                 s t r i n g   e r r _ m e s s a g e   =   ( ( m s g   = =   n u l l   | |   m s g . T r i m ( )   = =   " " )   ?   " E R R O R ! "   :  
                                 ( e r r M e s s a g e s [ m s g ]   = =   n u l l   ?   m s g   :   e r r M e s s a g e s [ m s g ] . T o S t r i n g ( ) )  
                         ) ;  
  
                 / /   H a l t   e x e c u t o n   a f t e r   f l u s h i n g   t h e   e r r o r   m e s s a g e   t o   r e s p o n s e   ( i f   h a l t   i s   t r u e )  
                 i f   ( h a l t )  
                 {  
                         f l u s h S t a t u s ( f a l s e ,   n e w   H a s h t a b l e ( ) ,   e r r _ m e s s a g e ) ;  
  
                 }  
                 / /   a d d   e r r o r   t o   n o t i c e s   g l o b a l   v a r i a b l e  
                 e l s e  
                 {  
                         n o t i c e s   + =   e r r _ m e s s a g e ;  
                 }  
  
         }  
  
  
  
 }  
  
  
 / / /   < s u m m a r y >  
 / / /   F u s i o n C h a r t s   I m a g e   G e n e r a t o r   C l a s s  
 / / /   F u s i o n C h a r t s   E x p o r t e r   -   ' I m a g e   R e s o u r c e '   h a n d l e s    
 / / /   F u s i o n C h a r t s   ( s i n c e   v 3 . 1 )   S e r v e r   S i d e   E x p o r t   f e a t u r e   t h a t  
 / / /   h e l p s   F u s i o n C h a r t s   e x p o r t e d   a s   I m a g e   f i l e s   i n   v a r i o u s   f o r m a t s .    
 / / /   < / s u m m a r y >  
 p u b l i c   c l a s s   F C I M G G e n e r a t o r  
 {  
         / / A r r a y   -   S t o r e s   m u l t i p l e   c h a r t   e x p o r t   d a t a  
         p r i v a t e   A r r a y L i s t   a r r E x p o r t D a t a   =   n e w   A r r a y L i s t ( ) ;  
         / / s t o r e s   n u m b e r   o f   p a g e s   =   l e n g t h   o f   $ a r r E x p o r t D a t a   a r r a y  
         p r i v a t e   i n t   n u m P a g e s   =   0 ;  
 	  
  
 	 / / /   < s u m m a r y >  
 	 / / /   G e n e r a t e s   b i t m a p   d a t a   f o r   t h e   i m a g e   f r o m   a   F u s i o n C h a r t s   e x p o r t   f o r m a t  
 	 / / /   t h e   h e i g h t   a n d   w i d t h   o f   t h e   o r i g i n a l   e x p o r t   n e e d s   t o   b e   s p e c i f i e d  
 	 / / /   t h e   d e f a u l t   b a c k g r o u n d   c o l o r   c a n   a l s o   b e   s p e c i f i e d  
 	 / / /   < / s u m m a r y >  
         p u b l i c   F C I M G G e n e r a t o r ( s t r i n g   i m a g e D a t a _ F C F o r m a t ,   s t r i n g   w i d t h ,   s t r i n g   h e i g h t ,   s t r i n g   b g c o l o r )  
         {  
                 s e t B i t m a p D a t a ( i m a g e D a t a _ F C F o r m a t ,   w i d t h ,   h e i g h t ,   b g c o l o r ) ;  
         }  
 	  
 	 / / /   < s u m m a r y >  
 	 / / /   G e t s   t h e   b i n a r y   d a t a   s t r e a m   o f   t h e   i m a g e  
 	 / / /   T h e   p a s s e d   p a r a m e t e r   d e t e r m i n e s   t h e   f i l e   f o r m a t   o f   t h e   i m a g e  
 	 / / /   t o   b e   e x p o r t e d  
 	 / / /   < / s u m m a r y >  
         p u b l i c   M e m o r y S t r e a m   g e t B i n a r y S t r e a m ( s t r i n g   s t r F o r m a t )  
         {  
 	 	  
 	 	 / /   t h e   i m a g e   o b j e c t    
                 B i t m a p   e x p o r t O b j   =   g e t I m a g e O b j e c t ( ) ;  
 	 	  
 	 	 / /   i n i t i a t e s   a   n e w   b i n a r y   d a t a   s r e a m  
                 M e m o r y S t r e a m   o u t S t r e a m   =   n e w   M e m o r y S t r e a m ( ) ;  
 	 	  
 	 	 / /   d e t e r m i n e s   t h e   i m a g e   f o r m a t  
                 s w i t c h   ( s t r F o r m a t )  
                 {  
                         c a s e   " j p g " :  
                         c a s e   " j p e g " :  
                                 e x p o r t O b j . S a v e ( o u t S t r e a m ,   I m a g e F o r m a t . J p e g ) ;  
                                 b r e a k ;  
                         c a s e   " p n g " :  
                                 e x p o r t O b j . S a v e ( o u t S t r e a m ,   I m a g e F o r m a t . P n g ) ;  
                                 b r e a k ;  
                         c a s e   " g i f " :  
                                 e x p o r t O b j . S a v e ( o u t S t r e a m , I m a g e F o r m a t . G i f ) ;  
                                 b r e a k ;  
                         c a s e   " t i f f " :  
                                 e x p o r t O b j . S a v e ( o u t S t r e a m ,   I m a g e F o r m a t . T i f f ) ;  
                                 b r e a k ;  
                         d e f a u l t :  
                                 e x p o r t O b j . S a v e ( o u t S t r e a m ,   I m a g e F o r m a t . B m p ) ;  
                                 b r e a k ;  
                 }  
                 e x p o r t O b j . D i s p o s e ( ) ;  
  
                 r e t u r n   o u t S t r e a m ;  
  
         }  
 	  
 	  
 	 / / /   < s u m m a r y >  
 	 / / /   G e n e r a t e s   b i t m a p   d a t a   f o r   t h e   i m a g e   f r o m   a   F u s i o n C h a r t s   e x p o r t   f o r m a t  
 	 / / /   t h e   h e i g h t   a n d   w i d t h   o f   t h e   o r i g i n a l   e x p o r t   n e e d s   t o   b e   s p e c i f i e d  
 	 / / /   t h e   d e f a u l t   b a c k g r o u n d   c o l o r   c a n   a l s o   b e   s p e c i f i e d  
 	 / / /   < / s u m m a r y >  
         p r i v a t e   v o i d   s e t B i t m a p D a t a ( s t r i n g   i m a g e D a t a _ F C F o r m a t ,   s t r i n g   w i d t h ,   s t r i n g   h e i g h t ,   s t r i n g   b g c o l o r )  
         {  
                 H a s h t a b l e   c h a r t E x p o r t D a t a   =   n e w   H a s h t a b l e ( ) ;  
                 c h a r t E x p o r t D a t a [ " w i d t h " ]   =   w i d t h ;  
                 c h a r t E x p o r t D a t a [ " h e i g h t " ]   =   h e i g h t ;  
                 c h a r t E x p o r t D a t a [ " b g c o l o r " ]   =   b g c o l o r ;  
                 c h a r t E x p o r t D a t a [ " i m a g e d a t a " ]   =   i m a g e D a t a _ F C F o r m a t ;  
                 a r r E x p o r t D a t a . A d d ( c h a r t E x p o r t D a t a ) ;  
                 n u m P a g e s + + ;  
         }  
 	  
 	 / / /   < s u m m a r y >  
 	 / / /   G e n e r a t e s   b i t m a p   d a t a   f o r   t h e   i m a g e   f r o m   a   F u s i o n C h a r t s   e x p o r t   f o r m a t  
 	 / / /   t h e   h e i g h t   a n d   w i d t h   o f   t h e   o r i g i n a l   e x p o r t   n e e d s   t o   b e   s p e c i f i e d  
 	 / / /   t h e   d e f a u l t   b a c k g r o u n d   c o l o r   s h o u l d   a l s o   b e   s p e c i f i e d  
 	 / / /   < / s u m m a r y >  
         p r i v a t e   B i t m a p   g e t I m a g e O b j e c t ( i n t   i d )  
         {  
                 H a s h t a b l e   r a w I m a g e D a t a   =   ( H a s h t a b l e ) a r r E x p o r t D a t a [ i d ] ;  
  
                 / /   c r e a t e   b l a n k   b i t m a p   o b j e c t   w h i c h   w o u l d   s t o r e   i m a g e   p i x e l   d a t a  
                 B i t m a p   i m a g e   =   n e w   B i t m a p ( C o n v e r t . T o I n t 1 6 ( r a w I m a g e D a t a [ " w i d t h " ] ) ,   C o n v e r t . T o I n t 1 6 ( r a w I m a g e D a t a [ " h e i g h t " ] ) ,   S y s t e m . D r a w i n g . I m a g i n g . P i x e l F o r m a t . F o r m a t 2 4 b p p R g b ) ;  
  
                 / /   d r w a i n g   s u r f a c e  
                 G r a p h i c s   g r   =   G r a p h i c s . F r o m I m a g e ( i m a g e ) ;  
  
                 / /   s e t   b a c k g r o u n d   c o l o r  
                 g r . C l e a r ( C o l o r T r a n s l a t o r . F r o m H t m l ( " # "   +   r a w I m a g e D a t a [ " b g c o l o r " ] . T o S t r i n g ( ) ) ) ;  
  
                 s t r i n g [ ]   r o w s   =   r a w I m a g e D a t a [ " i m a g e d a t a " ] . T o S t r i n g ( ) . S p l i t ( ' ; ' ) ;  
  
                 f o r   ( i n t   y P i x e l   =   0 ;   y P i x e l   <   r o w s . L e n g t h ;   y P i x e l + + )  
                 {  
                         / / S p l i t   e a c h   r o w   i n t o   ' c o l o r _ c o u n t '   c o l u m n s . 	 	 	  
                         S t r i n g [ ]   c o l o r _ c o u n t   =   r o w s [ y P i x e l ] . S p l i t ( ' , ' ) ;  
                         / / S e t   h o r i z o n t a l   r o w   i n d e x   t o   0  
                         i n t   x P i x e l   =   0 ;  
  
                         f o r   ( i n t   c o l   =   0 ;   c o l   <   c o l o r _ c o u n t . L e n g t h ;   c o l + + )  
                         {  
                                 / / N o w ,   i f   i t ' s   n o t   e m p t y ,   w e   p r o c e s s   i t 	 	 	 	  
                                 / / S p l i t   t h e   ' c o l o r _ c o u n t '   i n t o   c o l o r   a n d   r e p e a t   f a c t o r  
                                 S t r i n g [ ]   s p l i t _ d a t a   =   c o l o r _ c o u n t [ c o l ] . S p l i t ( ' _ ' ) ;  
  
                                 / / R e f e r e n c e   t o   c o l o r  
                                 s t r i n g   h e x C o l o r   =   s p l i t _ d a t a [ 0 ] ;  
                                 / / r e f e r   t o   r e p e a t   f a c t o r  
                                 i n t   f R e p e a t   =   i n t . P a r s e ( s p l i t _ d a t a [ 1 ] ) ;  
  
                                 / / I f   c o l o r   i s   n o t   e m p t y   ( i . e .   n o t   b a c k g r o u n d   p i x e l )  
                                 i f   ( h e x C o l o r   ! =   " " )  
                                 {  
                                         / / I f   t h e   h e x a d e c i m a l   c o d e   i s   l e s s   t h a n   6   c h a r a c t e r s ,   p a d   w i t h   0  
                                         h e x C o l o r   =   h e x C o l o r . L e n g t h   <   6   ?   h e x C o l o r . P a d L e f t ( 6 ,   ' 0 ' )   :   h e x C o l o r ;  
                                         f o r   ( i n t   k   =   1 ;   k   < =   f R e p e a t ;   k + + )  
                                         {  
  
                                                 / / d r a w   p i x e l   w i t h   s p e c i f i e d   c o l o r  
                                                 i m a g e . S e t P i x e l ( x P i x e l ,   y P i x e l ,   C o l o r T r a n s l a t o r . F r o m H t m l ( " # "   +   h e x C o l o r ) ) ;  
                                                 / / I n c r e m e n t   h o r i z o n t a l   r o w   c o u n t  
                                                 x P i x e l + + ;  
                                         }  
                                 }  
                                 e l s e  
                                 {  
                                         / / J u s t   i n c r e m e n t   h o r i z o n t a l   i n d e x  
                                         x P i x e l   + =   f R e p e a t ;  
                                 }  
                         }  
                 }  
                 g r . D i s p o s e ( ) ;  
                 r e t u r n   i m a g e ;  
  
         }  
  
         / / /   < s u m m a r y >  
 	 / / /   R e t r e i v e s   t h e   b i t m a p   i m a g e   o b j e c t  
 	 / / /   < / s u m m a r y >  
 	 p r i v a t e   B i t m a p   g e t I m a g e O b j e c t ( )  
         {  
                 r e t u r n   g e t I m a g e O b j e c t ( 0 ) ;  
         }  
  
 }  
  
  
 / / /   < s u m m a r y >  
 / / /   F u s i o n C h a r t s   E x p o r t e r   -   ' P D F   R e s o u r c e '   h a n d l e s    
 / / /   F u s i o n C h a r t s   ( s i n c e   v 3 . 1 )   S e r v e r   S i d e   E x p o r t   f e a t u r e   t h a t  
 / / /   h e l p s   F u s i o n C h a r t s   e x p o r t e d   a s   P D F   f i l e .  
 / / /   < / s u m m a r y >  
 p u b l i c   c l a s s   F C P D F G e n e r a t o r  
 {  
  
         / / A r r a y   -   S t o r e s   m u l t i p l e   c h a r t   e x p o r t   d a t a  
         p r i v a t e   A r r a y L i s t   a r r E x p o r t D a t a   =   n e w   A r r a y L i s t ( ) ;  
         / / s t o r e s   n u m b e r   o f   p a g e s   =   l e n g t h   o f   $ a r r E x p o r t D a t a   a r r a y  
         p r i v a t e   i n t   n u m P a g e s   =   0 ;  
 	  
 	 / / /   < s u m m a r y >  
 	 / / /   G e n e r a t e s   a   P D F   f i l e   w i t h   t h e   g i v e n   p a r a m e t e r s  
 	 / / /   T h e   i m a g e D a t a _ F C F o r m a t   p a r a m e t e r   i s   t h e   F u s i o n C h a r t s   e x p o r t   f o r m a t   d a t a  
 	 / / /   w i d t h ,   h e i g h t   a r e   t h e   r e s p e c t i v e   w i d t h   a n d   h e i g h t   o f   t h e   o r i g i n a l   i m a g e  
 	 / / /   b g c o l o r   d e t e r m i n e s   t h e   d e f a u l t   b a c k g r o u n d   c o l o u r  
 	 / / /   < / s u m m a r y >  
         p u b l i c   F C P D F G e n e r a t o r ( s t r i n g   i m a g e D a t a _ F C F o r m a t ,   s t r i n g   w i d t h ,   s t r i n g   h e i g h t ,   s t r i n g   b g c o l o r )  
         {  
                 s e t B i t m a p D a t a ( i m a g e D a t a _ F C F o r m a t ,   w i d t h ,   h e i g h t ,   b g c o l o r ) ;  
         }  
 	  
 	 / / /   < s u m m a r y >  
 	 / / /   G e t s   t h e   b i n a r y   d a t a   s t r e a m   o f   t h e   i m a g e  
 	 / / /   T h e   p a s s e d   p a r a m e t e r   d e t e r m i n e s   t h e   f i l e   f o r m a t   o f   t h e   i m a g e  
 	 / / /   t o   b e   e x p o r t e d  
 	 / / /   < / s u m m a r y >  
         p u b l i c   M e m o r y S t r e a m   g e t B i n a r y S t r e a m ( s t r i n g   s t r F o r m a t )  
         {  
                 b y t e [ ]   e x p o r t O b j   =   g e t P D F O b j e c t s ( t r u e ) ;  
  
                 M e m o r y S t r e a m   o u t S t r e a m   =   n e w   M e m o r y S t r e a m ( ) ;  
  
                 o u t S t r e a m . W r i t e ( e x p o r t O b j ,   0 ,   e x p o r t O b j . L e n g t h ) ;  
  
                 r e t u r n   o u t S t r e a m ;  
  
         }  
  
 	 / / /   < s u m m a r y >  
 	 / / /   G e n e r a t e s   b i t m a p   d a t a   f o r   t h e   i m a g e   f r o m   a   F u s i o n C h a r t s   e x p o r t   f o r m a t  
 	 / / /   t h e   h e i g h t   a n d   w i d t h   o f   t h e   o r i g i n a l   e x p o r t   n e e d s   t o   b e   s p e c i f i e d  
 	 / / /   t h e   d e f a u l t   b a c k g r o u n d   c o l o r   s h o u l d   a l s o   b e   s p e c i f i e d  
 	 / / /   < / s u m m a r y >  
         p r i v a t e   v o i d   s e t B i t m a p D a t a ( s t r i n g   i m a g e D a t a _ F C F o r m a t ,   s t r i n g   w i d t h ,   s t r i n g   h e i g h t ,   s t r i n g   b g c o l o r )  
         {  
                 H a s h t a b l e   c h a r t E x p o r t D a t a   =   n e w   H a s h t a b l e ( ) ;  
                 c h a r t E x p o r t D a t a [ " w i d t h " ]   =   w i d t h ;  
                 c h a r t E x p o r t D a t a [ " h e i g h t " ]   =   h e i g h t ;  
                 c h a r t E x p o r t D a t a [ " b g c o l o r " ]   =   b g c o l o r ;  
                 c h a r t E x p o r t D a t a [ " i m a g e d a t a " ]   =   i m a g e D a t a _ F C F o r m a t ;  
                 a r r E x p o r t D a t a . A d d ( c h a r t E x p o r t D a t a ) ;  
                 n u m P a g e s + + ;  
         }  
  
  
  
         / / c r e a t e   i m a g e   P D F   o b j e c t   c o n t a i n i n g   t h e   c h a r t   i m a g e    
         p r i v a t e   b y t e [ ]   a d d I m a g e T o P D F ( i n t   i d ,   b o o l   i s C o m p r e s s e d )  
         {  
  
                 M e m o r y S t r e a m   i m g O b j   =   n e w   M e m o r y S t r e a m ( ) ;  
  
                 / / P D F   O b j e c t   n u m b e r  
                 i n t   i m g O b j N o   =   6   +   i d   *   3 ;  
  
                 / / G e t   c h a r t   I m a g e   b i n a r y  
                 b y t e [ ]   i m g B i n a r y   =   g e t B i t m a p D a t a 2 4 ( i d ,   i s C o m p r e s s e d ) ;  
  
                 / / g e t   t h e   l e n g t h   o f   t h e   i m a g e   b i n a r y  
                 i n t   l e n   =   i m g B i n a r y . L e n g t h ;  
  
                 s t r i n g   w i d t h   =   g e t M e t a ( " w i d t h " ,   i d ) ;  
                 s t r i n g   h e i g h t   =   g e t M e t a ( " h e i g h t " ,   i d ) ;  
  
                 / / B u i l d   P D F   o b j e c t   c o n t a i n i n g   t h e   i m a g e   b i n a r y   a n d   o t h e r   f o r m a t s   r e q u i r e d  
                 / / s t r i n g   s t r I m g O b j H e a d   =   i m g O b j N o . T o S t r i n g ( )   +   "   0   o b j \ n < < \ n / S u b t y p e   / I m a g e   / C o l o r S p a c e   / D e v i c e R G B   / B i t s P e r C o m p o n e n t   8   / H D P I   7 2   / V D P I   7 2   "   +   ( i s C o m p r e s s e d   ?   " "   :   " " )   +   " / W i d t h   "   +   w i d t h   +   "   / H e i g h t   "   +   h e i g h t   +   "   / L e n g t h   "   +   l e n . T o S t r i n g ( )   +   "   > > \ n s t r e a m \ n " ;  
                 s t r i n g   s t r I m g O b j H e a d   =   i m g O b j N o . T o S t r i n g ( )   +   "   0   o b j \ n < < \ n / S u b t y p e   / I m a g e   / C o l o r S p a c e   / D e v i c e R G B   / B i t s P e r C o m p o n e n t   8   / H D P I   7 2   / V D P I   7 2   "   +   ( i s C o m p r e s s e d   ?   " / F i l t e r   / R u n L e n g t h D e c o d e   "   :   " " )   +   " / W i d t h   "   +   w i d t h   +   "   / H e i g h t   "   +   h e i g h t   +   "   / L e n g t h   "   +   l e n . T o S t r i n g ( )   +   "   > > \ n s t r e a m \ n " ;  
  
  
  
                 i m g O b j . W r i t e ( s t r i n g T o B y t e s ( s t r I m g O b j H e a d ) ,   0 ,   s t r I m g O b j H e a d . L e n g t h ) ;  
                 i m g O b j . W r i t e ( i m g B i n a r y ,   0 ,   ( i n t ) i m g B i n a r y . L e n g t h ) ;  
  
                 s t r i n g   s t r I m g O b j E n d   =   " e n d s t r e a m \ n e n d o b j \ n " ;  
                 i m g O b j . W r i t e ( s t r i n g T o B y t e s ( s t r I m g O b j E n d ) ,   0 ,   s t r I m g O b j E n d . L e n g t h ) ;  
  
                 i m g O b j . C l o s e ( ) ;  
                 r e t u r n   i m g O b j . T o A r r a y ( ) ;  
  
         }  
         p r i v a t e   b y t e [ ]   a d d I m a g e T o P D F ( i n t   i d )  
         {  
                 r e t u r n   a d d I m a g e T o P D F ( i d ,   t r u e ) ;  
         }  
         p r i v a t e   b y t e [ ]   a d d I m a g e T o P D F ( )  
         {  
                 r e t u r n   a d d I m a g e T o P D F ( 0 ,   t r u e ) ;  
         }  
  
  
  
         / / M a i n   P D F   b u i l d e r   f u n c t i o n  
         p r i v a t e   b y t e [ ]   g e t P D F O b j e c t s ( )  
         {  
                 r e t u r n   g e t P D F O b j e c t s ( t r u e ) ;  
         }  
  
         p r i v a t e   b y t e [ ]   g e t P D F O b j e c t s ( b o o l   i s C o m p r e s s e d )  
         {  
                 M e m o r y S t r e a m   P D F B y t e s   =   n e w   M e m o r y S t r e a m ( ) ;  
  
                 / / S t o r e   a l l   P D F   o b j e c t s   i n   t h i s   t e m p o r a r y   s t r i n g   t o   b e   w r i t t e n   t o   B y t e A r r a y  
                 s t r i n g   s t r T m p O b j   =   " " ;  
  
  
                 / / s t a r t   x r e f   a r r a y  
                 A r r a y L i s t   x R e f L i s t   =   n e w   A r r a y L i s t ( ) ;  
                 x R e f L i s t . A d d ( " x r e f \ n 0   " ) ;  
                 x R e f L i s t . A d d ( " 0 0 0 0 0 0 0 0 0 0   6 5 5 3 5   f   \ n " ) ;   / / A d d r e s s   R e f e n r e c e   t o   o b j   0  
  
                 / / B u i l d   P D F   o b j e c t s   s e q u e n t i a l l y  
                 / / v e r s i o n   a n d   h e a d e r  
                 s t r T m p O b j   =   " % P D F - 1 . 3 \ n % { F C } \ n " ;  
                 P D F B y t e s . W r i t e ( s t r i n g T o B y t e s ( s t r T m p O b j ) ,   0 ,   s t r T m p O b j . L e n g t h ) ;  
  
                 / / O B J E C T   1   :   i n f o   ( o p t i o n a l )  
                 s t r T m p O b j   =   " 1   0   o b j < < \ n / A u t h o r   ( F u s i o n C h a r t s ) \ n / T i t l e   ( F u s i o n C h a r t s ) \ n / C r e a t o r   ( F u s i o n C h a r t s ) \ n > > \ n e n d o b j \ n " ;  
                 x R e f L i s t . A d d ( c a l c u l a t e X P o s ( ( i n t ) P D F B y t e s . L e n g t h ) ) ;   / / r e f e n r e c e   t o   o b j   1  
                 P D F B y t e s . W r i t e ( s t r i n g T o B y t e s ( s t r T m p O b j ) ,   0 ,   s t r T m p O b j . L e n g t h ) ;  
  
                 / / O B J E C T   2   :   S t a r t s   w i t h   P a g e s   C a t a l o g u e  
                 s t r T m p O b j   =   " 2   0   o b j \ n < <   / T y p e   / C a t a l o g   / P a g e s   3   0   R   > > \ n e n d o b j \ n " ;  
                 x R e f L i s t . A d d ( c a l c u l a t e X P o s ( ( i n t ) P D F B y t e s . L e n g t h ) ) ;   / / r e f e n r e c e   t o   o b j   2  
                 P D F B y t e s . W r i t e ( s t r i n g T o B y t e s ( s t r T m p O b j ) ,   0 ,   s t r T m p O b j . L e n g t h ) ;  
  
                 / / O B J E C T   3   :   P a g e   T r e e   ( r e f e r e n c e   t o   p a g e s   o f   t h e   c a t a l o g u e )  
                 s t r T m p O b j   =   " 3   0   o b j \ n < <     / T y p e   / P a g e s   / K i d s   [ " ;  
                 f o r   ( i n t   i   =   0 ;   i   <   n u m P a g e s ;   i + + )  
                 {  
                         s t r T m p O b j   + =   ( ( ( i   +   1 )   *   3 )   +   1 )   +   "   0   R \ n " ;  
                 }  
                 s t r T m p O b j   + =   " ]   / C o u n t   "   +   n u m P a g e s   +   "   > > \ n e n d o b j \ n " ;  
  
                 x R e f L i s t . A d d ( c a l c u l a t e X P o s ( ( i n t ) P D F B y t e s . L e n g t h ) ) ;   / / r e f e n r e c e   t o   o b j   3  
                 P D F B y t e s . W r i t e ( s t r i n g T o B y t e s ( s t r T m p O b j ) ,   0 ,   s t r T m p O b j . L e n g t h ) ;  
  
  
                 / / E a c h   i m a g e   p a g e  
                 f o r   ( i n t   i t r   =   0 ;   i t r   <   n u m P a g e s ;   i t r + + )  
                 {  
                         s t r i n g   i W i d t h   =   g e t M e t a ( " w i d t h " ,   i t r ) ;  
                         s t r i n g   i H e i g h t   =   g e t M e t a ( " h e i g h t " ,   i t r ) ;  
                         / / O B J E C T   4 . . 7 . . 1 0 . . n   :   P a g e   c o n f i g  
                         s t r T m p O b j   =   ( ( ( i t r   +   2 )   *   3 )   -   2 )   +   "   0   o b j \ n < < \ n / T y p e   / P a g e   / P a r e n t   3   0   R   \ n / M e d i a B o x   [   0   0   "   +   i W i d t h   +   "   "   +   i H e i g h t   +   "   ] \ n / R e s o u r c e s   < < \ n / P r o c S e t   [   / P D F   ] \ n / X O b j e c t   < < / R "   +   ( i t r   +   1 )   +   "   "   +   ( ( i t r   +   2 )   *   3 )   +   "   0   R > > \ n > > \ n / C o n t e n t s   [   "   +   ( ( ( i t r   +   2 )   *   3 )   -   1 )   +   "   0   R   ] \ n > > \ n e n d o b j \ n " ;  
                         x R e f L i s t . A d d ( c a l c u l a t e X P o s ( ( i n t ) P D F B y t e s . L e n g t h ) ) ;   / / r e f e n r e c e   t o   o b j   4 , 7 , 1 0 , 1 3 , 1 6 . . .  
                         P D F B y t e s . W r i t e ( s t r i n g T o B y t e s ( s t r T m p O b j ) ,   0 ,   s t r T m p O b j . L e n g t h ) ;  
  
  
                         / / O B J E C T   5 . . . 8 . . . 1 1 . . . n   :   P a g e   r e s o u r c e   o b j e c t   ( x o b j e c t   r e s o u r c e   t h a t   t r a n s f o r m s   t h e   i m a g e )  
                         x R e f L i s t . A d d ( c a l c u l a t e X P o s ( ( i n t ) P D F B y t e s . L e n g t h ) ) ;   / / r e f e n r e c e   t o   o b j   5 , 8 , 1 1 , 1 4 , 1 7 . . .  
                         s t r i n g   x O b j R   =   g e t X O b j R e s o u r c e ( i t r ) ;  
                         P D F B y t e s . W r i t e ( s t r i n g T o B y t e s ( x O b j R ) ,   0 ,   x O b j R . L e n g t h ) ;  
  
                         / / O B J E C T   6 . . . 9 . . . 1 2 . . . n   :   B i n a r y   x o b j e c t   o f   t h e   p a g e   ( i m a g e )  
                         b y t e [ ]   i m g B A   =   a d d I m a g e T o P D F ( i t r ,   i s C o m p r e s s e d ) ;  
                         x R e f L i s t . A d d ( c a l c u l a t e X P o s ( ( i n t ) P D F B y t e s . L e n g t h ) ) ; / / r e f e n r e c e   t o   o b j   6 , 9 , 1 2 , 1 5 , 1 8 . . .  
                         P D F B y t e s . W r i t e ( i m g B A ,   0 ,   i m g B A . L e n g t h ) ;  
                 }  
  
                 / / x r e f s 	 c o m p i l a t i o n  
                 x R e f L i s t [ 0 ]   + =   ( ( x R e f L i s t . C o u n t   -   1 )   +   " \ n " ) ;  
  
                 / / g e t   t r a i l e r  
                 s t r i n g   t r a i l e r   =   g e t T r a i l e r ( ( i n t ) P D F B y t e s . L e n g t h ,   x R e f L i s t . C o u n t   -   1 ) ;  
  
                 / / w r i t e   x r e f   a n d   t r a i l e r   t o   P D F  
                 s t r i n g   s t r X R e f s   =   s t r i n g . J o i n ( " " ,   ( s t r i n g [ ] ) x R e f L i s t . T o A r r a y ( t y p e o f ( s t r i n g ) ) ) ;  
                 P D F B y t e s . W r i t e ( s t r i n g T o B y t e s ( s t r X R e f s ) ,   0 ,   s t r X R e f s . L e n g t h ) ;  
                 / /  
                 P D F B y t e s . W r i t e ( s t r i n g T o B y t e s ( t r a i l e r ) ,   0 ,   t r a i l e r . L e n g t h ) ;  
  
                 / / w r i t e   E O F  
                 s t r i n g   s t r E O F   =   " % % E O F \ n " ;  
                 P D F B y t e s . W r i t e ( s t r i n g T o B y t e s ( s t r E O F ) ,   0 ,   s t r E O F . L e n g t h ) ;  
  
                 P D F B y t e s . C l o s e ( ) ;  
                 r e t u r n   P D F B y t e s . T o A r r a y ( ) ;  
  
         }  
  
  
         / / B u i l d   I m a g e   r e s o u r c e   o b j e c t   t h a t   t r a n s f o r m s   t h e   i m a g e   f r o m   F i r s t   Q u a d r a n t   s y s t e m   t o   S e c o n d   Q u a d r a n t   s y s t e m  
         p r i v a t e   s t r i n g   g e t X O b j R e s o u r c e ( )  
         {  
                 r e t u r n   g e t X O b j R e s o u r c e ( 0 ) ;  
         }  
         p r i v a t e   s t r i n g   g e t X O b j R e s o u r c e ( i n t   i t r )  
         {  
  
                 s t r i n g   w i d t h   =   g e t M e t a ( " w i d t h " ,   i t r ) ;  
                 s t r i n g   h e i g h t   =   g e t M e t a ( " h e i g h t " ,   i t r ) ;  
                 r e t u r n   ( ( ( i t r   +   2 )   *   3 )   -   1 )   +   "   0   o b j \ n < <   / L e n g t h   "   +   ( 2 4   +   ( w i d t h   +   h e i g h t ) . L e n g t h )   +   "   > > \ n s t r e a m \ n q \ n "   +   w i d t h   +   "   0   0   "   +   h e i g h t   +   "   0   0   c m \ n / R "   +   ( i t r   +   1 )   +   "   D o \ n Q \ n e n d s t r e a m \ n e n d o b j \ n " ;  
         }  
  
         p r i v a t e   s t r i n g   c a l c u l a t e X P o s ( i n t   p o s n )  
         {  
                 r e t u r n   p o s n . T o S t r i n g ( ) . P a d L e f t ( 1 0 ,   ' 0 ' )   +   "   0 0 0 0 0   n   \ n " ;  
         }  
  
  
         p r i v a t e   s t r i n g   g e t T r a i l e r ( i n t   x r e f p o s )  
         {  
                 r e t u r n   g e t T r a i l e r ( x r e f p o s ,   7 ) ;  
         }  
  
         p r i v a t e   s t r i n g   g e t T r a i l e r ( i n t   x r e f p o s ,   i n t   n u m x r e f )  
         {  
                 r e t u r n   " t r a i l e r \ n < < \ n / S i z e   "   +   n u m x r e f . T o S t r i n g ( )   +   " \ n / R o o t   2   0   R \ n / I n f o   1   0   R \ n > > \ n s t a r t x r e f \ n "   +   x r e f p o s . T o S t r i n g ( )   +   " \ n " ;  
         }  
  
  
         p r i v a t e   b y t e [ ]   g e t B i t m a p D a t a 2 4 ( )  
         {  
                 r e t u r n   g e t B i t m a p D a t a 2 4 ( 0 ,   t r u e ) ;  
         }  
         p r i v a t e   b y t e [ ]   g e t B i t m a p D a t a 2 4 ( i n t   i d ,   b o o l   i s C o m p r e s s e d )  
         {  
  
                 s t r i n g   r a w I m a g e D a t a   =   g e t M e t a ( " i m a g e d a t a " ,   i d ) ;  
                 s t r i n g   b g C o l o r   =   g e t M e t a ( " b g c o l o r " ,   i d ) ;  
  
                 M e m o r y S t r e a m   i m a g e D a t a 2 4   =   n e w   M e m o r y S t r e a m ( ) ;  
  
                 / /   S p l i t   t h e   d a t a   i n t o   r o w s   u s i n g   ;   a s   s e p a r a t o r  
                 s t r i n g [ ]   r o w s   =   r a w I m a g e D a t a . S p l i t ( ' ; ' ) ;  
  
                 f o r   ( i n t   y P i x e l   =   0 ;   y P i x e l   <   r o w s . L e n g t h ;   y P i x e l + + )  
                 {  
                         / / S p l i t   e a c h   r o w   i n t o   ' c o l o r _ c o u n t '   c o l u m n s . 	 	 	  
                         s t r i n g [ ]   c o l o r _ c o u n t   =   r o w s [ y P i x e l ] . S p l i t ( ' , ' ) ;  
  
                         f o r   ( i n t   c o l   =   0 ;   c o l   <   c o l o r _ c o u n t . L e n g t h ;   c o l + + )  
                         {  
                                 / / N o w ,   i f   i t ' s   n o t   e m p t y ,   w e   p r o c e s s   i t 	 	 	 	  
                                 / / S p l i t   t h e   ' c o l o r _ c o u n t '   i n t o   c o l o r   a n d   r e p e a t   f a c t o r  
                                 s t r i n g [ ]   s p l i t _ d a t a   =   c o l o r _ c o u n t [ c o l ] . S p l i t ( ' _ ' ) ;  
  
                                 / / R e f e r e n c e   t o   c o l o r  
                                 s t r i n g   h e x C o l o r   =   s p l i t _ d a t a [ 0 ]   ! =   " "   ?   s p l i t _ d a t a [ 0 ]   :   b g C o l o r ;  
                                 / / I f   t h e   h e x a d e c i m a l   c o d e   i s   l e s s   t h a n   6   c h a r a c t e r s ,   p a d   w i t h   0  
                                 h e x C o l o r   =   h e x C o l o r . L e n g t h   <   6   ?   h e x C o l o r . P a d L e f t ( 6 ,   ' 0 ' )   :   h e x C o l o r ;  
  
                                 / / r e f e r   t o   r e p e a t   f a c t o r  
                                 i n t   f R e p e a t   =   i n t . P a r s e ( s p l i t _ d a t a [ 1 ] ) ;  
  
                                 / /   c o n v e r t   c o l o r   s t r i n g   t o   b y t e [ ]   a r r a y  
                                 b y t e [ ]   r g b   =   h e x T o B y t e s ( h e x C o l o r ) ;  
  
                                 / /   S e t   t h e   r e p e a t e d   p i x e l   i n   M e m o r y S t r e a m  
                                 f o r   ( i n t   c R e p e a t   =   0 ;   c R e p e a t   <   f R e p e a t ;   c R e p e a t + + )  
                                 {  
                                         i m a g e D a t a 2 4 . W r i t e ( r g b ,   0 ,   3 ) ;  
                                 }  
  
                         }  
                 }  
  
                 i n t   l e n   =   ( i n t ) i m a g e D a t a 2 4 . L e n g t h ;  
                 i m a g e D a t a 2 4 . C l o s e ( ) ;  
  
                 / / C o m p r e s s   i m a g e   b i n a r y  
                 i f   ( i s C o m p r e s s e d )  
                 {  
                         r e t u r n   n e w   P D F C o m p r e s s ( i m a g e D a t a 2 4 . T o A r r a y ( ) ) . R L E C o m p r e s s ( ) ;  
                 }  
                 e l s e  
                 {  
                         r e t u r n   i m a g e D a t a 2 4 . T o A r r a y ( ) ;  
                 }  
         }  
 	  
 	 / /   c o n v e r t s   a   h e x a d e c i m a l   c o l o u r   s t r i n g   t o   i t ' s   r e s p e c t i v e   b y t e   v a l u e  
         p r i v a t e   b y t e [ ]   h e x T o B y t e s ( s t r i n g   s t r H e x )  
         {  
                 i f   ( s t r H e x   = =   n u l l   | |   s t r H e x . T r i m ( ) . L e n g t h   = =   0 )   s t r H e x   =   " 0 0 " ;  
                 s t r H e x   =   R e g e x . R e p l a c e ( s t r H e x ,   @ " [ ^ 0 - 9 a - f A - f ] " ,   " " ) ;  
                 i f   ( s t r H e x . L e n g t h   %   2   ! =   0 )   s t r H e x   =   " 0 "   +   s t r H e x ;  
  
                 i n t   l e n   =   s t r H e x . L e n g t h   /   2 ;  
                 b y t e [ ]   b y t e s   =   n e w   b y t e [ l e n ] ;  
  
                 f o r   ( i n t   i   =   0 ;   i   <   l e n ;   i + + )  
                 {  
                         s t r i n g   h e x   =   s t r H e x . S u b s t r i n g ( i   *   2 ,   2 ) ;  
                         b y t e s [ i ]   =   b y t e . P a r s e ( h e x ,   S y s t e m . G l o b a l i z a t i o n . N u m b e r S t y l e s . H e x N u m b e r ) ;  
                 }  
                 r e t u r n   b y t e s ;  
  
         }  
  
         p r i v a t e   s t r i n g   g e t M e t a ( s t r i n g   m e t a N a m e )  
         {  
                 r e t u r n   g e t M e t a ( m e t a N a m e ,   0 ) ;  
         }  
  
         p r i v a t e   s t r i n g   g e t M e t a ( s t r i n g   m e t a N a m e ,   i n t   i d )  
         {  
                 i f   ( m e t a N a m e   = =   n u l l )   m e t a N a m e   =   " " ;  
                 H a s h t a b l e   c h a r t D a t a   =   ( H a s h t a b l e ) a r r E x p o r t D a t a [ i d ] ;  
                 r e t u r n   ( c h a r t D a t a [ m e t a N a m e ]   = =   n u l l   ?   " "   :   c h a r t D a t a [ m e t a N a m e ] . T o S t r i n g ( ) ) ;  
         }  
  
         p r i v a t e   b y t e [ ]   s t r i n g T o B y t e s ( s t r i n g   s t r )  
         {  
                 i f   ( s t r   = =   n u l l )   s t r   =   " " ;  
                 r e t u r n   S y s t e m . T e x t . E n c o d i n g . A S C I I . G e t B y t e s ( s t r ) ;  
         }  
  
  
 }  
  
  
 / / /   < s u m m a r y >  
 / / /   T h i s   i s   a n   a d - h o c   c l a s s   t o   c o m p r e s s   P D F   s t r e a m .  
 / / /   C u r r e n t l y   t h i s   c l a s s   c o m p r e s s e s   b i n a r y   ( b y t e )   s t r e a m   u s i n g   R L E   w h i c h    
 / / /   P D F   1 . 3   s p e c i f i c a t i o n   h a s   t h u s   f o r m u l a t e d :  
 / / /    
 / / /   T h e   R u n L e n g t h D e c o d e   f i l t e r   d e c o d e s   d a t a   t h a t   h a s   b e e n   e n c o d e d   i n   a   s i m p l e    
 / / /   b y t e - o r i e n t e d   f o r m a t   b a s e d   o n   r u n   l e n g t h .   T h e   e n c o d e d   d a t a   i s   a   s e q u e n c e   o f    
 / / /   r u n s ,   w h e r e   e a c h   r u n   c o n s i s t s   o f   a   l e n g t h   b y t e   f o l l o w e d   b y   1   t o   1 2 8   b y t e s   o f   d a t a .   I f    
 / / /   t h e   l e n g t h   b y t e   i s   i n   t h e   r a n g e   0   t o   1 2 7 ,   t h e   f o l l o w i n g   l e n g t h   +   1   ( 1   t o   1 2 8 )   b y t e s    
 / / /   a r e   c o p i e d   l i t e r a l l y   d u r i n g   d e c o m p r e s s i o n .   I f   l e n g t h   i s   i n   t h e   r a n g e   1 2 9   t o   2 5 5 ,   t h e    
 / / /   f o l l o w i n g   s i n g l e   b y t e   i s   t o   b e   c o p i e d   2 5 7   "  l e n g t h   ( 2   t o   1 2 8 )   t i m e s   d u r i n g   d e c o m p r e s s i o n .    
 / / /   A   l e n g t h   v a l u e   o f   1 2 8   d e n o t e s   E O D .  
 / / /    
 / / /   T h e   c h a r t   i m a g e   c o m p r e s s i o n   r a t i o   c o m e s   t o   a r o u n d   1 0 : 3    
 / / /    
 / / /   < / s u m m a r y >  
 p u b l i c   c l a s s   P D F C o m p r e s s  
 {  
  
         / / /   < s u m m a r y >  
         / / /   s t o r e s   t h e   o u t p u t   c o m p r e s s e d   d a t a   i n   M e m o r y S t r e a m   o b j e c t   l a t e r   t o   b e   c o n v e r t e d   t o   b y t e [ ]   a r r a y  
         / / /   < / s u m m a r y >  
         p r i v a t e   M e m o r y S t r e a m   _ C o m p r e s s e d   =   n e w   M e m o r y S t r e a m ( ) ;  
  
         / / /   < s u m m a r y >  
         / / /     U n c o m p r e s s e s   d a t a   a s   b y t e [ ]   a r r a y  
         / / /   < / s u m m a r y >  
         p r i v a t e   b y t e [ ]   _ U n C o m p r e s s e d ;  
  
  
         / / /   < s u m m a r y >  
         / / /   T a k e s   t h e   u n c o m p r e s s e d   b y t e   a r r a y  
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " U n C o m p r e s s e d " > u n c o m p r e s s e d   d a t a < / p a r a m >  
         p u b l i c   P D F C o m p r e s s ( b y t e [ ]   U n C o m p r e s s e d )  
         {  
                 _ U n C o m p r e s s e d   =   U n C o m p r e s s e d ;  
         }  
  
         / / /   < s u m m a r y >  
         / / /   W r i t e   c o m p r e s s e d   d a t a   a s   R u n L e n g t h  
         / / /   < / s u m m a r y >  
         / / /   < p a r a m   n a m e = " l e n g t h " > T h e   l e n g t h   o f   r e p e a t e d   d a t a < / p a r a m >  
         / / /   < p a r a m   n a m e = " e n c o d e e " > T h e   b y t e   t o   b e   r e p e a t e d < / p a r a m >  
         / / /   < r e t u r n s > < / r e t u r n s >  
         p r i v a t e   i n t   W r i t e R u n L e n g t h ( i n t   l e n g t h ,   b y t e   e n c o d e e )  
         {  
                 / /   w r i t e   t h e   r e p e a t   l e n g t h  
                 _ C o m p r e s s e d . W r i t e B y t e ( ( b y t e ) ( 2 5 7   -   l e n g t h ) ) ;  
                 / /   w r i t e   t h e   b y t e   t o   b e   r e p e a t e d  
                 _ C o m p r e s s e d . W r i t e B y t e ( e n c o d e e ) ;  
  
                 / / r e - s e t   r e p e a t   l e n g t h  
                 l e n g t h   =   1 ;  
                 r e t u r n   l e n g t h ;  
         }  
  
         p r i v a t e   v o i d   W r i t e N o R e p e a t e r ( M e m o r y S t r e a m   N o R e p e a t B y t e s )  
         {  
                 / /   w r i t e   t h e   l e n g t h   o f   n o n   r e p e t e d   d a t a  
                 _ C o m p r e s s e d . W r i t e B y t e ( ( b y t e ) ( ( i n t ) N o R e p e a t B y t e s . L e n g t h   -   1 ) ) ;  
                 / /   w r i t e   t h e   n o n   r e p e a t e d   d a t a   p u t   l i t e r a l l y  
                 _ C o m p r e s s e d . W r i t e ( N o R e p e a t B y t e s . T o A r r a y ( ) ,   0 ,   ( i n t ) N o R e p e a t B y t e s . L e n g t h ) ;  
  
                 / /   r e - s e t   n o n   r e p e a t   b y t e   s t o r a g e   s t r e a m  
                 N o R e p e a t B y t e s . S e t L e n g t h ( 0 ) ;  
         }  
  
         / / /   < s u m m a r y >  
         / / /   c o m p r e s s e s   u n c o m p r e s s e d   d a t a   t o   c o m p r e s s e d   d a t a   i n   b y t e   a r r a y  
         / / /   < / s u m m a r y >  
         / / /   < r e t u r n s > < / r e t u r n s >  
         p u b l i c   b y t e [ ]   R L E C o m p r e s s ( )  
         {  
                 / /   s t o r e s   n o n   r e p e a t a b l e   d a t a  
                 M e m o r y S t r e a m   N o R e p e a t   =   n e w   M e m o r y S t r e a m ( ) ;  
  
                 / /   r e p e a t   c o u n t e r  
                 i n t   _ R L   =   1 ;  
  
                 / /   2   c o n s e c u t i v e   b y t e s   t o   c o m p a r e  
                 b y t e   p r e B y t e   =   0 ,   p o s t B y t e   =   0 ;  
  
                 / /   i t e r a t e   t h r o u g h   t h e   u n c o m p r e s s e d   b y t e s  
                 f o r   ( i n t   i   =   0 ;   i   <   _ U n C o m p r e s s e d . L e n g t h   -   1 ;   i + + )  
                 {  
                         / /   g e t   2   c o n s e c u t i v e   b y t e s  
                         p r e B y t e   =   _ U n C o m p r e s s e d [ i ] ;  
                         p o s t B y t e   =   _ U n C o m p r e s s e d [ i   +   1 ] ;  
  
                         / /   i f   b o t h   a r e   s a m e   t h e r e   i s   s c o p e   f o r   r e p i t i t i o n  
                         i f   ( p r e B y t e   = =   p o s t B y t e )  
                         {  
                                 / /   b u t   f l u s h   t h e   n o n   r e p e a t a b l e   d a t a   ( i f   p r e s e n t )   t o   c o m p r e s s e d   s t r e a m    
                                 i f   ( N o R e p e a t . L e n g t h   >   0 )   W r i t e N o R e p e a t e r ( N o R e p e a t ) ;    
  
                                 / /   i n c r e a s e   r e p e a t   c o u n t  
                                 _ R L + + ;  
                                  
                                 / /   i f   r e p e a t   c o u n t   r e a c h e s   l i m i t   o f   r e p e a t   i . e .   1 2 8    
                                 / /   w r i t e   t h e   r e p e a t   d a t a   a n d   r e s e t   t h e   r e p e a t   c o u n t e r  
                                 i f   ( _ R L   >   1 2 8 )   _ R L   =   W r i t e R u n L e n g t h ( _ R L - 1 , p r e B y t e ) ;    
  
                         }  
                         e l s e  
                         {  
                                 / /   w h e n   c o n s e c u t i v e   b y t e s   d o   n o t   m a t c h  
  
                                 / /   s t o r e   n o n - r e p e a t a b l e   d a t a  
                                 i f   ( _ R L   = =   1 )   N o R e p e a t . W r i t e B y t e ( p r e B y t e ) ;  
  
                                 / /   w r i t e   r e p e a t e d   l e n g t h   a n d   b y t e   ( i f   p r e s e n t   )   t o   o u t p u t   s t r e a m  
                                 i f   ( _ R L   >   1 )     _ R L   =   W r i t e R u n L e n g t h ( _ R L ,   p r e B y t e ) ;  
                                  
                                 / /   w r i t e   n o n   r e p e a t a b l e   d a t a   t o   o u t   p u t   s t r e a m   i f   t h e   l e n g t h   r e a c h e s   l i m i t  
                                 i f   ( N o R e p e a t . L e n g t h   = =   1 2 8 )   W r i t e N o R e p e a t e r ( N o R e p e a t ) ;    
                         }  
                 }  
      
                 / /   a t   t h e   e n d   o f   i t e r a t i o n    
                 / /   t a k e   c a r e   o f   t h e   l a s t   b y t e  
  
                 / /   i f   r e p e a t e d    
                 i f   ( _ R L   >   1 )    
                 {  
                         / /   w r i t e   r u n   l e n g t h   a n d   b y t e   ( i f   p r e s e n t   )   t o   o u t p u t   s t r e a m  
                         _ R L   =   W r i t e R u n L e n g t h ( _ R L ,   p r e B y t e ) ;    
                 }  
                 e l s e  
                 {  
                         / /   i f   n o n   r e p e a t e d   b y t e   i s   l e f t   b e h i n d  
                         / /   w r i t e   n o n   r e p e a t a b l e   d a t a   t o   o u t p u t   s t r e a m    
                         N o R e p e a t . W r i t e B y t e ( p o s t B y t e ) ;  
                         W r i t e N o R e p e a t e r ( N o R e p e a t ) ;  
                 }  
  
                  
                 / /   w r o t e   E O D  
                 _ C o m p r e s s e d . W r i t e B y t e ( ( b y t e ) 1 2 8 ) ;  
  
                 / / c l o s e   s t r e a m s  
                 N o R e p e a t . C l o s e ( ) ;  
                 _ C o m p r e s s e d . C l o s e ( ) ;  
  
                 / /   r e t u r n   c o m p r e s s e d   d a t a   i n   b y t e   a r r a y  
                 r e t u r n   _ C o m p r e s s e d . T o A r r a y ( ) ;  
         }  
  
 }  
  
 