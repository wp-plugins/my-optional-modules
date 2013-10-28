<?php if( !defined( 'MyOptionalModules' ) ) { die( 'You can not call this file directly.' ); }

    //    MY OPTIONAL MODULES
    //        MODULE: JUMP AROUND

    if (is_admin() ) {
    
        function my_optional_modules_jump_around_module() {
        
            
            function update_JA() {
                update_option( 'jump_around_0',$_REQUEST[ 'jump_around_0' ] );
                update_option( 'jump_around_1',$_REQUEST[ 'jump_around_1' ] );
                update_option( 'jump_around_2',$_REQUEST[ 'jump_around_2' ] );
                update_option( 'jump_around_3',$_REQUEST[ 'jump_around_3' ] );
                update_option( 'jump_around_4',$_REQUEST[ 'jump_around_4' ] );
                update_option( 'jump_around_5',$_REQUEST[ 'jump_around_5' ] );
                update_option( 'jump_around_6',$_REQUEST[ 'jump_around_6' ] );
                update_option( 'jump_around_7',$_REQUEST[ 'jump_around_7' ] );
                update_option( 'jump_around_8',$_REQUEST[ 'jump_around_8' ] );
                echo "<meta http-equiv=\"refresh\" content=\"0;url=\"" . plugin_basename(__FILE__) . "\" />";
            }

            if ($_REQUEST["update_JA"]) { update_JA(); }
            
            function print_jump_around_form() {
                echo "
                <td>
                    <table class=\"form-table\" border=\"1\" style=\"margin:5px;\">
                        <tbody>
                            <tr valign=\"top\">
                                <th scope=\"row\"><label for=\"jump_around_0\">Post container:</label></th>
                                <td><input type=\"text\" name=\"jump_around_0\" value=\"" . get_option( 'jump_around_0' ) . "\" /></td>
                                </tr>
                                <tr valign=\"top\">
                                <th scope=\"row\"><label for=\"jump_around_1\">Permalink:</label></th>
                                <td><input type=\"text\" name=\"jump_around_1\" value=\"" . get_option( 'jump_around_1' ) . "\" /></td>
                                </tr>
                                <tr valign=\"top\">
                                <th scope=\"row\"><label for=\"jump_around_2\">Previous posts</label></th>
                                <td><input type=\"text\" name=\"jump_around_2\" value=\"" . get_option( 'jump_around_2' ) . "\" /></td>
                                </tr>
                                <tr valign=\"top\">
                                <th scope=\"row\"><label for=\"jump_around_3\">Next posts</label></th>
                                <td><input type=\"text\" name=\"jump_around_3\" value=\"" . get_option( 'jump_around_3' ) . "\" /></td>
                            </tr>
                            <tr valign=\"top\">
                                <th scope=\"row\">
                                    <label for=\"jump_around_4\">Previous key</label>
                                </th>
                                <td>
                                    <select name=\"jump_around_4\">
                                        <option value=\"65\""; if ( get_option( 'jump_around_4' ) == '65' ) { echo " selected=\"selected\""; } echo ">a</option>
                                        <option value=\"66\""; if ( get_option( 'jump_around_4' ) == '66' ) { echo " selected=\"selected\""; } echo ">b</option>
                                        <option value=\"67\""; if ( get_option( 'jump_around_4' ) == '67' ) { echo " selected=\"selected\""; } echo ">c</option>
                                        <option value=\"68\""; if ( get_option( 'jump_around_4' ) == '68' ) { echo " selected=\"selected\""; } echo ">d</option>
                                        <option value=\"69\""; if ( get_option( 'jump_around_4' ) == '69' ) { echo " selected=\"selected\""; } echo ">e</option>
                                        <option value=\"70\""; if ( get_option( 'jump_around_4' ) == '70' ) { echo " selected=\"selected\""; } echo ">f</option>
                                        <option value=\"71\""; if ( get_option( 'jump_around_4' ) == '71' ) { echo " selected=\"selected\""; } echo ">g</option>
                                        <option value=\"72\""; if ( get_option( 'jump_around_4' ) == '72' ) { echo " selected=\"selected\""; } echo ">h</option>
                                        <option value=\"73\""; if ( get_option( 'jump_around_4' ) == '73' ) { echo " selected=\"selected\""; } echo ">i</option>
                                        <option value=\"74\""; if ( get_option( 'jump_around_4' ) == '74' ) { echo " selected=\"selected\""; } echo ">j</option>
                                        <option value=\"75\""; if ( get_option( 'jump_around_4' ) == '75' ) { echo " selected=\"selected\""; } echo ">k</option>
                                        <option value=\"76\""; if ( get_option( 'jump_around_4' ) == '76' ) { echo " selected=\"selected\""; } echo ">l</option>
                                        <option value=\"77\""; if ( get_option( 'jump_around_4' ) == '77' ) { echo " selected=\"selected\""; } echo ">m</option>
                                        <option value=\"78\""; if ( get_option( 'jump_around_4' ) == '78' ) { echo " selected=\"selected\""; } echo ">n</option>
                                        <option value=\"79\""; if ( get_option( 'jump_around_4' ) == '79' ) { echo " selected=\"selected\""; } echo ">o</option>
                                        <option value=\"80\""; if ( get_option( 'jump_around_4' ) == '80' ) { echo " selected=\"selected\""; } echo ">p</option>
                                        <option value=\"81\""; if ( get_option( 'jump_around_4' ) == '81' ) { echo " selected=\"selected\""; } echo ">q</option>
                                        <option value=\"82\""; if ( get_option( 'jump_around_4' ) == '82' ) { echo " selected=\"selected\""; } echo ">r</option>
                                        <option value=\"83\""; if ( get_option( 'jump_around_4' ) == '83' ) { echo " selected=\"selected\""; } echo ">s</option>
                                        <option value=\"84\""; if ( get_option( 'jump_around_4' ) == '84' ) { echo " selected=\"selected\""; } echo ">t</option>
                                        <option value=\"85\""; if ( get_option( 'jump_around_4' ) == '85' ) { echo " selected=\"selected\""; } echo ">u</option>
                                        <option value=\"86\""; if ( get_option( 'jump_around_4' ) == '86' ) { echo " selected=\"selected\""; } echo ">v</option>
                                        <option value=\"87\""; if ( get_option( 'jump_around_4' ) == '87' ) { echo " selected=\"selected\""; } echo ">w</option>
                                        <option value=\"88\""; if ( get_option( 'jump_around_4' ) == '88' ) { echo " selected=\"selected\""; } echo ">x</option>
                                        <option value=\"89\""; if ( get_option( 'jump_around_4' ) == '89' ) { echo " selected=\"selected\""; } echo ">y</option>
                                        <option value=\"90\""; if ( get_option( 'jump_around_4' ) == '90' ) { echo " selected=\"selected\""; } echo ">z</option>
                                        <option value=\"48\""; if ( get_option( 'jump_around_4' ) == '48' ) { echo " selected=\"selected\""; } echo ">0</option>
                                        <option value=\"49\""; if ( get_option( 'jump_around_4' ) == '49' ) { echo " selected=\"selected\""; } echo ">1</option>
                                        <option value=\"50\""; if ( get_option( 'jump_around_4' ) == '50' ) { echo " selected=\"selected\""; } echo ">2</option>
                                        <option value=\"51\""; if ( get_option( 'jump_around_4' ) == '51' ) { echo " selected=\"selected\""; } echo ">3</option>
                                        <option value=\"52\""; if ( get_option( 'jump_around_4' ) == '52' ) { echo " selected=\"selected\""; } echo ">4</option>
                                        <option value=\"53\""; if ( get_option( 'jump_around_4' ) == '53' ) { echo " selected=\"selected\""; } echo ">5</option>
                                        <option value=\"54\""; if ( get_option( 'jump_around_4' ) == '54' ) { echo " selected=\"selected\""; } echo ">6</option>
                                        <option value=\"55\""; if ( get_option( 'jump_around_4' ) == '55' ) { echo " selected=\"selected\""; } echo ">7</option>
                                        <option value=\"56\""; if ( get_option( 'jump_around_4' ) == '56' ) { echo " selected=\"selected\""; } echo ">8</option>
                                        <option value=\"57\""; if ( get_option( 'jump_around_4' ) == '57' ) { echo " selected=\"selected\""; } echo ">9</option>
                                        <option value=\"37\""; if ( get_option( 'jump_around_4' ) == '37' ) { echo " selected=\"selected\""; } echo ">left arrow</option>
                                        <option value=\"38\""; if ( get_option( 'jump_around_4' ) == '38' ) { echo " selected=\"selected\""; } echo ">up arrow</option>
                                        <option value=\"39\""; if ( get_option( 'jump_around_4' ) == '39' ) { echo " selected=\"selected\""; } echo ">right arrow</option>
                                        <option value=\"40\""; if ( get_option( 'jump_around_4' ) == '40' ) { echo " selected=\"selected\""; } echo ">down arrow</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign=\"top\">
                                <th scope=\"row\">
                                    <label for=\"jump_around_5\">Open currently selected key</label>
                                </th>
                                <td>
                                    <select name=\"jump_around_5\">
                                        <option value=\"65\""; if ( get_option( 'jump_around_5' ) == '65' ) { echo " selected=\"selected\""; } echo ">a</option>
                                        <option value=\"66\""; if ( get_option( 'jump_around_5' ) == '66' ) { echo " selected=\"selected\""; } echo ">b</option>
                                        <option value=\"67\""; if ( get_option( 'jump_around_5' ) == '67' ) { echo " selected=\"selected\""; } echo ">c</option>
                                        <option value=\"68\""; if ( get_option( 'jump_around_5' ) == '68' ) { echo " selected=\"selected\""; } echo ">d</option>
                                        <option value=\"69\""; if ( get_option( 'jump_around_5' ) == '69' ) { echo " selected=\"selected\""; } echo ">e</option>
                                        <option value=\"70\""; if ( get_option( 'jump_around_5' ) == '70' ) { echo " selected=\"selected\""; } echo ">f</option>
                                        <option value=\"71\""; if ( get_option( 'jump_around_5' ) == '71' ) { echo " selected=\"selected\""; } echo ">g</option>
                                        <option value=\"72\""; if ( get_option( 'jump_around_5' ) == '72' ) { echo " selected=\"selected\""; } echo ">h</option>
                                        <option value=\"73\""; if ( get_option( 'jump_around_5' ) == '73' ) { echo " selected=\"selected\""; } echo ">i</option>
                                        <option value=\"74\""; if ( get_option( 'jump_around_5' ) == '74' ) { echo " selected=\"selected\""; } echo ">j</option>
                                        <option value=\"75\""; if ( get_option( 'jump_around_5' ) == '75' ) { echo " selected=\"selected\""; } echo ">k</option>
                                        <option value=\"76\""; if ( get_option( 'jump_around_5' ) == '76' ) { echo " selected=\"selected\""; } echo ">l</option>
                                        <option value=\"77\""; if ( get_option( 'jump_around_5' ) == '77' ) { echo " selected=\"selected\""; } echo ">m</option>
                                        <option value=\"78\""; if ( get_option( 'jump_around_5' ) == '78' ) { echo " selected=\"selected\""; } echo ">n</option>
                                        <option value=\"79\""; if ( get_option( 'jump_around_5' ) == '79' ) { echo " selected=\"selected\""; } echo ">o</option>
                                        <option value=\"80\""; if ( get_option( 'jump_around_5' ) == '80' ) { echo " selected=\"selected\""; } echo ">p</option>
                                        <option value=\"81\""; if ( get_option( 'jump_around_5' ) == '81' ) { echo " selected=\"selected\""; } echo ">q</option>
                                        <option value=\"82\""; if ( get_option( 'jump_around_5' ) == '82' ) { echo " selected=\"selected\""; } echo ">r</option>
                                        <option value=\"83\""; if ( get_option( 'jump_around_5' ) == '83' ) { echo " selected=\"selected\""; } echo ">s</option>
                                        <option value=\"84\""; if ( get_option( 'jump_around_5' ) == '84' ) { echo " selected=\"selected\""; } echo ">t</option>
                                        <option value=\"85\""; if ( get_option( 'jump_around_5' ) == '85' ) { echo " selected=\"selected\""; } echo ">u</option>
                                        <option value=\"86\""; if ( get_option( 'jump_around_5' ) == '86' ) { echo " selected=\"selected\""; } echo ">v</option>
                                        <option value=\"87\""; if ( get_option( 'jump_around_5' ) == '87' ) { echo " selected=\"selected\""; } echo ">w</option>
                                        <option value=\"88\""; if ( get_option( 'jump_around_5' ) == '88' ) { echo " selected=\"selected\""; } echo ">x</option>
                                        <option value=\"89\""; if ( get_option( 'jump_around_5' ) == '89' ) { echo " selected=\"selected\""; } echo ">y</option>
                                        <option value=\"90\""; if ( get_option( 'jump_around_5' ) == '90' ) { echo " selected=\"selected\""; } echo ">z</option>
                                        <option value=\"48\""; if ( get_option( 'jump_around_5' ) == '48' ) { echo " selected=\"selected\""; } echo ">0</option>
                                        <option value=\"49\""; if ( get_option( 'jump_around_5' ) == '49' ) { echo " selected=\"selected\""; } echo ">1</option>
                                        <option value=\"50\""; if ( get_option( 'jump_around_5' ) == '50' ) { echo " selected=\"selected\""; } echo ">2</option>
                                        <option value=\"51\""; if ( get_option( 'jump_around_5' ) == '51' ) { echo " selected=\"selected\""; } echo ">3</option>
                                        <option value=\"52\""; if ( get_option( 'jump_around_5' ) == '52' ) { echo " selected=\"selected\""; } echo ">4</option>
                                        <option value=\"53\""; if ( get_option( 'jump_around_5' ) == '53' ) { echo " selected=\"selected\""; } echo ">5</option>
                                        <option value=\"54\""; if ( get_option( 'jump_around_5' ) == '54' ) { echo " selected=\"selected\""; } echo ">6</option>
                                        <option value=\"55\""; if ( get_option( 'jump_around_5' ) == '55' ) { echo " selected=\"selected\""; } echo ">7</option>
                                        <option value=\"56\""; if ( get_option( 'jump_around_5' ) == '56' ) { echo " selected=\"selected\""; } echo ">8</option>
                                        <option value=\"57\""; if ( get_option( 'jump_around_5' ) == '57' ) { echo " selected=\"selected\""; } echo ">9</option>
                                        <option value=\"37\""; if ( get_option( 'jump_around_5' ) == '37' ) { echo " selected=\"selected\""; } echo ">left arrow</option>
                                        <option value=\"38\""; if ( get_option( 'jump_around_5' ) == '38' ) { echo " selected=\"selected\""; } echo ">up arrow</option>
                                        <option value=\"39\""; if ( get_option( 'jump_around_5' ) == '39' ) { echo " selected=\"selected\""; } echo ">right arrow</option>
                                        <option value=\"40\""; if ( get_option( 'jump_around_5' ) == '40' ) { echo " selected=\"selected\""; } echo ">down arrow</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign=\"top\">
                                <th scope=\"row\">
                                    <label for=\"jump_around_6\">Next key</label>
                                </th>
                                <td>
                                    <select name=\"jump_around_6\">
                                        <option value=\"65\""; if ( get_option( 'jump_around_6' ) == '65' ) { echo " selected=\"selected\""; } echo ">a</option>
                                        <option value=\"66\""; if ( get_option( 'jump_around_6' ) == '66' ) { echo " selected=\"selected\""; } echo ">b</option>
                                        <option value=\"67\""; if ( get_option( 'jump_around_6' ) == '67' ) { echo " selected=\"selected\""; } echo ">c</option>
                                        <option value=\"68\""; if ( get_option( 'jump_around_6' ) == '68' ) { echo " selected=\"selected\""; } echo ">d</option>
                                        <option value=\"69\""; if ( get_option( 'jump_around_6' ) == '69' ) { echo " selected=\"selected\""; } echo ">e</option>
                                        <option value=\"70\""; if ( get_option( 'jump_around_6' ) == '70' ) { echo " selected=\"selected\""; } echo ">f</option>
                                        <option value=\"71\""; if ( get_option( 'jump_around_6' ) == '71' ) { echo " selected=\"selected\""; } echo ">g</option>
                                        <option value=\"72\""; if ( get_option( 'jump_around_6' ) == '72' ) { echo " selected=\"selected\""; } echo ">h</option>
                                        <option value=\"73\""; if ( get_option( 'jump_around_6' ) == '73' ) { echo " selected=\"selected\""; } echo ">i</option>
                                        <option value=\"74\""; if ( get_option( 'jump_around_6' ) == '74' ) { echo " selected=\"selected\""; } echo ">j</option>
                                        <option value=\"75\""; if ( get_option( 'jump_around_6' ) == '75' ) { echo " selected=\"selected\""; } echo ">k</option>
                                        <option value=\"76\""; if ( get_option( 'jump_around_6' ) == '76' ) { echo " selected=\"selected\""; } echo ">l</option>
                                        <option value=\"77\""; if ( get_option( 'jump_around_6' ) == '77' ) { echo " selected=\"selected\""; } echo ">m</option>
                                        <option value=\"78\""; if ( get_option( 'jump_around_6' ) == '78' ) { echo " selected=\"selected\""; } echo ">n</option>
                                        <option value=\"79\""; if ( get_option( 'jump_around_6' ) == '79' ) { echo " selected=\"selected\""; } echo ">o</option>
                                        <option value=\"80\""; if ( get_option( 'jump_around_6' ) == '80' ) { echo " selected=\"selected\""; } echo ">p</option>
                                        <option value=\"81\""; if ( get_option( 'jump_around_6' ) == '81' ) { echo " selected=\"selected\""; } echo ">q</option>
                                        <option value=\"82\""; if ( get_option( 'jump_around_6' ) == '82' ) { echo " selected=\"selected\""; } echo ">r</option>
                                        <option value=\"83\""; if ( get_option( 'jump_around_6' ) == '83' ) { echo " selected=\"selected\""; } echo ">s</option>
                                        <option value=\"84\""; if ( get_option( 'jump_around_6' ) == '84' ) { echo " selected=\"selected\""; } echo ">t</option>
                                        <option value=\"85\""; if ( get_option( 'jump_around_6' ) == '85' ) { echo " selected=\"selected\""; } echo ">u</option>
                                        <option value=\"86\""; if ( get_option( 'jump_around_6' ) == '86' ) { echo " selected=\"selected\""; } echo ">v</option>
                                        <option value=\"87\""; if ( get_option( 'jump_around_6' ) == '87' ) { echo " selected=\"selected\""; } echo ">w</option>
                                        <option value=\"88\""; if ( get_option( 'jump_around_6' ) == '88' ) { echo " selected=\"selected\""; } echo ">x</option>
                                        <option value=\"89\""; if ( get_option( 'jump_around_6' ) == '89' ) { echo " selected=\"selected\""; } echo ">y</option>
                                        <option value=\"90\""; if ( get_option( 'jump_around_6' ) == '90' ) { echo " selected=\"selected\""; } echo ">z</option>
                                        <option value=\"48\""; if ( get_option( 'jump_around_6' ) == '48' ) { echo " selected=\"selected\""; } echo ">0</option>
                                        <option value=\"49\""; if ( get_option( 'jump_around_6' ) == '49' ) { echo " selected=\"selected\""; } echo ">1</option>
                                        <option value=\"50\""; if ( get_option( 'jump_around_6' ) == '50' ) { echo " selected=\"selected\""; } echo ">2</option>
                                        <option value=\"51\""; if ( get_option( 'jump_around_6' ) == '51' ) { echo " selected=\"selected\""; } echo ">3</option>
                                        <option value=\"52\""; if ( get_option( 'jump_around_6' ) == '52' ) { echo " selected=\"selected\""; } echo ">4</option>
                                        <option value=\"53\""; if ( get_option( 'jump_around_6' ) == '53' ) { echo " selected=\"selected\""; } echo ">5</option>
                                        <option value=\"54\""; if ( get_option( 'jump_around_6' ) == '54' ) { echo " selected=\"selected\""; } echo ">6</option>
                                        <option value=\"55\""; if ( get_option( 'jump_around_6' ) == '55' ) { echo " selected=\"selected\""; } echo ">7</option>
                                        <option value=\"56\""; if ( get_option( 'jump_around_6' ) == '56' ) { echo " selected=\"selected\""; } echo ">8</option>
                                        <option value=\"57\""; if ( get_option( 'jump_around_6' ) == '57' ) { echo " selected=\"selected\""; } echo ">9</option>
                                        <option value=\"37\""; if ( get_option( 'jump_around_6' ) == '37' ) { echo " selected=\"selected\""; } echo ">left arrow</option>
                                        <option value=\"38\""; if ( get_option( 'jump_around_6' ) == '38' ) { echo " selected=\"selected\""; } echo ">up arrow</option>
                                        <option value=\"39\""; if ( get_option( 'jump_around_6' ) == '39' ) { echo " selected=\"selected\""; } echo ">right arrow</option>
                                        <option value=\"40\""; if ( get_option( 'jump_around_6' ) == '40' ) { echo " selected=\"selected\""; } echo ">down arrow</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign=\"top\">
                                <th scope=\"row\">
                                    <label for=\"jump_around_7\">Older posts key</label>
                                </th>
                                <td>
                                    <select name=\"jump_around_7\">
                                        <option value=\"65\""; if ( get_option( 'jump_around_7' ) == '65' ) { echo " selected=\"selected\""; } echo ">a</option>
                                        <option value=\"66\""; if ( get_option( 'jump_around_7' ) == '66' ) { echo " selected=\"selected\""; } echo ">b</option>
                                        <option value=\"67\""; if ( get_option( 'jump_around_7' ) == '67' ) { echo " selected=\"selected\""; } echo ">c</option>
                                        <option value=\"68\""; if ( get_option( 'jump_around_7' ) == '68' ) { echo " selected=\"selected\""; } echo ">d</option>
                                        <option value=\"69\""; if ( get_option( 'jump_around_7' ) == '69' ) { echo " selected=\"selected\""; } echo ">e</option>
                                        <option value=\"70\""; if ( get_option( 'jump_around_7' ) == '70' ) { echo " selected=\"selected\""; } echo ">f</option>
                                        <option value=\"71\""; if ( get_option( 'jump_around_7' ) == '71' ) { echo " selected=\"selected\""; } echo ">g</option>
                                        <option value=\"72\""; if ( get_option( 'jump_around_7' ) == '72' ) { echo " selected=\"selected\""; } echo ">h</option>
                                        <option value=\"73\""; if ( get_option( 'jump_around_7' ) == '73' ) { echo " selected=\"selected\""; } echo ">i</option>
                                        <option value=\"74\""; if ( get_option( 'jump_around_7' ) == '74' ) { echo " selected=\"selected\""; } echo ">j</option>
                                        <option value=\"75\""; if ( get_option( 'jump_around_7' ) == '75' ) { echo " selected=\"selected\""; } echo ">k</option>
                                        <option value=\"76\""; if ( get_option( 'jump_around_7' ) == '76' ) { echo " selected=\"selected\""; } echo ">l</option>
                                        <option value=\"77\""; if ( get_option( 'jump_around_7' ) == '77' ) { echo " selected=\"selected\""; } echo ">m</option>
                                        <option value=\"78\""; if ( get_option( 'jump_around_7' ) == '78' ) { echo " selected=\"selected\""; } echo ">n</option>
                                        <option value=\"79\""; if ( get_option( 'jump_around_7' ) == '79' ) { echo " selected=\"selected\""; } echo ">o</option>
                                        <option value=\"80\""; if ( get_option( 'jump_around_7' ) == '80' ) { echo " selected=\"selected\""; } echo ">p</option>
                                        <option value=\"81\""; if ( get_option( 'jump_around_7' ) == '81' ) { echo " selected=\"selected\""; } echo ">q</option>
                                        <option value=\"82\""; if ( get_option( 'jump_around_7' ) == '82' ) { echo " selected=\"selected\""; } echo ">r</option>
                                        <option value=\"83\""; if ( get_option( 'jump_around_7' ) == '83' ) { echo " selected=\"selected\""; } echo ">s</option>
                                        <option value=\"84\""; if ( get_option( 'jump_around_7' ) == '84' ) { echo " selected=\"selected\""; } echo ">t</option>
                                        <option value=\"85\""; if ( get_option( 'jump_around_7' ) == '85' ) { echo " selected=\"selected\""; } echo ">u</option>
                                        <option value=\"86\""; if ( get_option( 'jump_around_7' ) == '86' ) { echo " selected=\"selected\""; } echo ">v</option>
                                        <option value=\"87\""; if ( get_option( 'jump_around_7' ) == '87' ) { echo " selected=\"selected\""; } echo ">w</option>
                                        <option value=\"88\""; if ( get_option( 'jump_around_7' ) == '88' ) { echo " selected=\"selected\""; } echo ">x</option>
                                        <option value=\"89\""; if ( get_option( 'jump_around_7' ) == '89' ) { echo " selected=\"selected\""; } echo ">y</option>
                                        <option value=\"90\""; if ( get_option( 'jump_around_7' ) == '90' ) { echo " selected=\"selected\""; } echo ">z</option>
                                        <option value=\"48\""; if ( get_option( 'jump_around_7' ) == '48' ) { echo " selected=\"selected\""; } echo ">0</option>
                                        <option value=\"49\""; if ( get_option( 'jump_around_7' ) == '49' ) { echo " selected=\"selected\""; } echo ">1</option>
                                        <option value=\"50\""; if ( get_option( 'jump_around_7' ) == '50' ) { echo " selected=\"selected\""; } echo ">2</option>
                                        <option value=\"51\""; if ( get_option( 'jump_around_7' ) == '51' ) { echo " selected=\"selected\""; } echo ">3</option>
                                        <option value=\"52\""; if ( get_option( 'jump_around_7' ) == '52' ) { echo " selected=\"selected\""; } echo ">4</option>
                                        <option value=\"53\""; if ( get_option( 'jump_around_7' ) == '53' ) { echo " selected=\"selected\""; } echo ">5</option>
                                        <option value=\"54\""; if ( get_option( 'jump_around_7' ) == '54' ) { echo " selected=\"selected\""; } echo ">6</option>
                                        <option value=\"55\""; if ( get_option( 'jump_around_7' ) == '55' ) { echo " selected=\"selected\""; } echo ">7</option>
                                        <option value=\"56\""; if ( get_option( 'jump_around_7' ) == '56' ) { echo " selected=\"selected\""; } echo ">8</option>
                                        <option value=\"57\""; if ( get_option( 'jump_around_7' ) == '57' ) { echo " selected=\"selected\""; } echo ">9</option>
                                        <option value=\"37\""; if ( get_option( 'jump_around_7' ) == '37' ) { echo " selected=\"selected\""; } echo ">left arrow</option>
                                        <option value=\"38\""; if ( get_option( 'jump_around_7' ) == '38' ) { echo " selected=\"selected\""; } echo ">up arrow</option>
                                        <option value=\"39\""; if ( get_option( 'jump_around_7' ) == '39' ) { echo " selected=\"selected\""; } echo ">right arrow</option>
                                        <option value=\"40\""; if ( get_option( 'jump_around_7' ) == '40' ) { echo " selected=\"selected\""; } echo ">down arrow</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign=\"top\">
                                <th scope=\"row\">
                                    <label for=\"jump_around_8\">Newer posts key</label>
                                </th>
                                <td>
                                    <select name=\"jump_around_8\">
                                        <option value=\"65\""; if ( get_option( 'jump_around_8' ) == '65' ) { echo " selected=\"selected\""; } echo ">a</option>
                                        <option value=\"66\""; if ( get_option( 'jump_around_8' ) == '66' ) { echo " selected=\"selected\""; } echo ">b</option>
                                        <option value=\"67\""; if ( get_option( 'jump_around_8' ) == '67' ) { echo " selected=\"selected\""; } echo ">c</option>
                                        <option value=\"68\""; if ( get_option( 'jump_around_8' ) == '68' ) { echo " selected=\"selected\""; } echo ">d</option>
                                        <option value=\"69\""; if ( get_option( 'jump_around_8' ) == '69' ) { echo " selected=\"selected\""; } echo ">e</option>
                                        <option value=\"70\""; if ( get_option( 'jump_around_8' ) == '70' ) { echo " selected=\"selected\""; } echo ">f</option>
                                        <option value=\"71\""; if ( get_option( 'jump_around_8' ) == '71' ) { echo " selected=\"selected\""; } echo ">g</option>
                                        <option value=\"72\""; if ( get_option( 'jump_around_8' ) == '72' ) { echo " selected=\"selected\""; } echo ">h</option>
                                        <option value=\"73\""; if ( get_option( 'jump_around_8' ) == '73' ) { echo " selected=\"selected\""; } echo ">i</option>
                                        <option value=\"74\""; if ( get_option( 'jump_around_8' ) == '74' ) { echo " selected=\"selected\""; } echo ">j</option>
                                        <option value=\"75\""; if ( get_option( 'jump_around_8' ) == '75' ) { echo " selected=\"selected\""; } echo ">k</option>
                                        <option value=\"76\""; if ( get_option( 'jump_around_8' ) == '76' ) { echo " selected=\"selected\""; } echo ">l</option>
                                        <option value=\"77\""; if ( get_option( 'jump_around_8' ) == '77' ) { echo " selected=\"selected\""; } echo ">m</option>
                                        <option value=\"78\""; if ( get_option( 'jump_around_8' ) == '78' ) { echo " selected=\"selected\""; } echo ">n</option>
                                        <option value=\"79\""; if ( get_option( 'jump_around_8' ) == '79' ) { echo " selected=\"selected\""; } echo ">o</option>
                                        <option value=\"80\""; if ( get_option( 'jump_around_8' ) == '80' ) { echo " selected=\"selected\""; } echo ">p</option>
                                        <option value=\"81\""; if ( get_option( 'jump_around_8' ) == '81' ) { echo " selected=\"selected\""; } echo ">q</option>
                                        <option value=\"82\""; if ( get_option( 'jump_around_8' ) == '82' ) { echo " selected=\"selected\""; } echo ">r</option>
                                        <option value=\"83\""; if ( get_option( 'jump_around_8' ) == '83' ) { echo " selected=\"selected\""; } echo ">s</option>
                                        <option value=\"84\""; if ( get_option( 'jump_around_8' ) == '84' ) { echo " selected=\"selected\""; } echo ">t</option>
                                        <option value=\"85\""; if ( get_option( 'jump_around_8' ) == '85' ) { echo " selected=\"selected\""; } echo ">u</option>
                                        <option value=\"86\""; if ( get_option( 'jump_around_8' ) == '86' ) { echo " selected=\"selected\""; } echo ">v</option>
                                        <option value=\"87\""; if ( get_option( 'jump_around_8' ) == '87' ) { echo " selected=\"selected\""; } echo ">w</option>
                                        <option value=\"88\""; if ( get_option( 'jump_around_8' ) == '88' ) { echo " selected=\"selected\""; } echo ">x</option>
                                        <option value=\"89\""; if ( get_option( 'jump_around_8' ) == '89' ) { echo " selected=\"selected\""; } echo ">y</option>
                                        <option value=\"90\""; if ( get_option( 'jump_around_8' ) == '90' ) { echo " selected=\"selected\""; } echo ">z</option>
                                        <option value=\"48\""; if ( get_option( 'jump_around_8' ) == '48' ) { echo " selected=\"selected\""; } echo ">0</option>
                                        <option value=\"49\""; if ( get_option( 'jump_around_8' ) == '49' ) { echo " selected=\"selected\""; } echo ">1</option>
                                        <option value=\"50\""; if ( get_option( 'jump_around_8' ) == '50' ) { echo " selected=\"selected\""; } echo ">2</option>
                                        <option value=\"51\""; if ( get_option( 'jump_around_8' ) == '51' ) { echo " selected=\"selected\""; } echo ">3</option>
                                        <option value=\"52\""; if ( get_option( 'jump_around_8' ) == '52' ) { echo " selected=\"selected\""; } echo ">4</option>
                                        <option value=\"53\""; if ( get_option( 'jump_around_8' ) == '53' ) { echo " selected=\"selected\""; } echo ">5</option>
                                        <option value=\"54\""; if ( get_option( 'jump_around_8' ) == '54' ) { echo " selected=\"selected\""; } echo ">6</option>
                                        <option value=\"55\""; if ( get_option( 'jump_around_8' ) == '55' ) { echo " selected=\"selected\""; } echo ">7</option>
                                        <option value=\"56\""; if ( get_option( 'jump_around_8' ) == '56' ) { echo " selected=\"selected\""; } echo ">8</option>
                                        <option value=\"57\""; if ( get_option( 'jump_around_8' ) == '57' ) { echo " selected=\"selected\""; } echo ">9</option>
                                        <option value=\"37\""; if ( get_option( 'jump_around_8' ) == '37' ) { echo " selected=\"selected\""; } echo ">left arrow</option>
                                        <option value=\"38\""; if ( get_option( 'jump_around_8' ) == '38' ) { echo " selected=\"selected\""; } echo ">up arrow</option>
                                        <option value=\"39\""; if ( get_option( 'jump_around_8' ) == '39' ) { echo " selected=\"selected\""; } echo ">right arrow</option>
                                        <option value=\"40\""; if ( get_option( 'jump_around_8' ) == '40' ) { echo " selected=\"selected\""; } echo ">down arrow</option>
                                    </select>
                                </td>
                                </tr>
                                <tr valign=\"top\">
                                    <td>
                                        <input id=\"update_JA\" type=\"submit\" value=\"Save Changes\" name=\"update_JA\">
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </td>";
            }

            function momja_page_content() { 
                echo "
                <div class=\"wrap\">
                    <h2>Jump Around</h2>
                    <form method=\"post\">
                        <table class=\"form-table\" border=\"1\">
                            <tbody>
                                <tr>
                                    <td valign=\"top\">
                                        Inputs accept a variety of queries:
                                        <table class=\"form-table\" border=\"1\" style=\"margin:5px;\">
                                            <tbody>
                                                <tr><td valign=\"top\">div class:</td><td valign=\"top\"><strong>.div</strong></td></tr>
                                                <tr><td valign=\"top\">link in div:</td><td valign=\"top\"><strong>.div a</strong></td></tr>
                                                <tr><td valign=\"top\">h1 in div:</td><td valign=\"top\"><strong>.div h1</strong></td></tr>
                                                <tr><td valign=\"top\">combination:</td><td valign=\"top\"><strong>.div h1 a</strong></td></tr>
                                            </tbody>
                                        </table>

                                        <p><em>Thanks to <a href=\"http://stackoverflow.com/questions/1939041/change-hash-without-reload-in-jquery\">jitter</a> &amp; <a href=\"http://stackoverflow.com/questions/13694277/scroll-to-next-div-using-arrow-keys\">mVChr</a> for the help.</em></p>";
                                        
                                        print_jump_around_form();
                                        
                            echo "
                            </tbody>
                        </table>
                    </form>
                </div>";
            }
            
            momja_page_content();
            
        }
        
        my_optional_modules_jump_around_module();
        
    }
    
?>