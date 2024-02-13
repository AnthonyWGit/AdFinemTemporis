***Overwiev***

This is my symfony 6.3 project.  
This is similiar in a way to the projects i did back in June and August.  
This'll be a pokemon-like game with some community functionnalities topped on it.

<details open><summary>Installation procedure</summary>

# **How to install**

1. **Install Symfony-cli** (https://symfony.com/download)

You can do it by using Scoop Shell or download the binaries for Windows.  
>scoop install symfony-cli  

For Unix systems use  
>curl -sS https://get.symfony.com/cli/installer | bash  

2. **Clone my repo**

Currently my dev branch is up ahead.  
>git clone -b https://github.com/AnthonyWGit/AdTemporisFinem-An-Exam-Project dev  

Or if you want master build  
>git clone -b https://github.com/AnthonyWGit/AdTemporisFinem-An-Exam-Project master  

3. **Install composer dependancies**

Install composer if it is not already done yet : https://getcomposer.org/download/  
Move into the cloned repository and install the vendor dir :  
>composer install

4. **Run a MySQL Service**

I use Laragon for my PHP projects. Just start the **mySQL** service.

5. **Import the Database**

It is necessary to use it in this project. The SQL import file is located in misc, use Db.sql

6. **Launch the Symfony local server**

Use this command :  
>symfony server:start  

Or if you want to use with daemon  
>symfony server:start -d    

7. **Grab a local smtp server** 

I really like maildev : https://github.com/maildev/maildev  
It **must** be running if you want to test registration.

</details>

<details open><summary>Encyclopedia</summary>

# **Encyclopedia**

- Navigate through every element in the game :
    - You can jump through some of them, like consulting a demon page and click on a skill to see the details of it 
    - When using admin rights, you can add/modify/delete elements

</details>

<details open><summary>Community</summary>

# **Community**
- Forum-lite part : suggestions are topics, but people cannot comment (yet)
- Most likes suggestions appear first
- Users are limited to make one until the admin marks it as accepted
- Can edit self suggestion
- Can delete own : need a confirmation modal on delete

</details>

<details open><summary>The Lab</summary>

# **The Lab** 
- Part where even non logged users can visit
- Damage simulator 
- Usage guide included : pick your demon, fill stats, select skill.
    - Proceed with the rest left blank to calculate PURE dmg (without reduction)
    - Fill the rest of the form to calculate damage with reduction
- It will display data about the calculations. **Need styling ASAP**

</details>

<details open><summary>Account</summary>

# **Account**
- User info
- Change password and email
- Can reset progression from beginning if not in combat
- Admin have a pannel to verify suggestions before they appear 
- Admin change users demons, add or delete them
- Same for items 

</details>

<details open><summary>Loggin</summary>

# **Loggin**
- Simple loggin
- Reset password 

</details>

<details open><summary>Game</summary>

# **Game**
- Turn-by-turn combat
- Text-based story
- Three starters
- Intended 15 min gameplay
- Music !
</details>

<details open><summary>What's next ?</summary>

# **To do**
- Capture system : new field needed in db for demon_player : order
- Animations
- SFX sounds (I lied current only have BGMs)
- Modal for responsive
- Buttons for responsive, logo for site
</details>

<details open><summary>Licence</summary>

# **Licence**
- This project is under MIT licence
</details>

<details open><summary>Credits</summary>

# **Credits**
- All the musicians who did the sound : 
    - Playsound : https://pixabay.com/fr/users/playsound-24686998/
    - JuliusH : https://pixabay.com/fr/users/juliush-3921568/
    - BoDleasons : https://pixabay.com/fr/users/bodleasons-28047609/
    
</details>