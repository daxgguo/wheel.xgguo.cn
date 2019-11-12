<?php


git 工作思路：
	1，本地创库：用于个人的项目版本管理
	2，远程仓库：用户多人协作版本开发管理
	3，本地通过管理远程仓库把本地内容合并到远程仓库






//安装完毕

// 1,设置用户名和email
	$ git config --global user.name "Your Name"
	$ git config --global user.email "email@example.com"

//2，创建文件夹，用作仓库
	$ mkdir learngit
	$ cd learngit
	$ pwd
	/Users/michael/learngit

//3，初始化仓库，通过git init命令把这个目录变成Git可以管理的仓库：
	$ git --bare init

//4，用命令git add告诉Git，把文件添加到仓库：
	$ git add readme.txt
	// git add -A  把变更的都add到缓存区

//删除缓存区的文件
	git rm --cached "文件路径"
	// 不删除物理文件，仅将该文件从缓存中删除；

//5，用命令git commit告诉Git，把文件提交到仓库：
	$ git commit -m "注释"

//6，git status命令可以让我们时刻掌握仓库当前的状态
	$ git status

//7，git diff顾名思义就是查看difference
	$ git diff readme.txt 

//8,git log命令显示从最近到最远的提交日志
	$ git log
//查看commit Id 
	$ git log --pretty=oneline

//9,一个版本就是HEAD^，上上一个版本就是HEAD^^，当然往上100个版本写100个^比较容易数不过来，所以写成HEAD~100。
//上个版本
	$ git reset --hard HEAD^
//某个版本
	$ git reset --hard 3628164
//要重返未来，用git reflog查看命令历史，以便确定要回到未来的哪个版本。
	$ git reflog

//10，Git会告诉你，git checkout -- file可以丢弃工作区的修改：
	$ git checkout -- readme.txt

//11,用命令git reset HEAD file可以把暂存区的修改撤销掉（unstage），重新放回工作区：
	$ git reset HEAD readme.txt

//12,通常直接在文件管理器中把没用的文件删了，或者用rm命令删了：
	$ rm test.txt
	//现在你有两个选择，一是确实要从版本库中删除该文件，那就用命令git rm删掉，并且git commit：
	$ git rm test.txt
	$ git commit -m "remove test.txt"
	//另一种情况是删错了，因为版本库里还有呢，所以可以很轻松地把误删的文件恢复到最新版本：
	$ git checkout -- test.txt


//远程仓库
	//第1步：创建SSH Key。在用户主目录下，看看有没有.ssh目录，如果有，再看看这个目录下有没有id_rsa和id_rsa.pub这两个文件，如果已经有了，可直接跳到下一步。如果没有，打开Shell（Windows下打开Git Bash），创建SSH Key：
	$ ssh-keygen -t rsa -C "youremail@example.com"
	//第2步：登陆GitHub，打开“Account settings”，“SSH Keys”页面：
	// 然后，点“Add SSH Key”，填上任意Title，在Key文本框里粘贴id_rsa.pub文件的内容：

	//第3步：登陆GitHub，然后，在右上角找到“Create a new repo”按钮，创建一个新的仓库：

	//第4步：在GitHub上的这个learngit仓库还是空的，GitHub告诉我们，可以从这个仓库克隆出新的仓库，也可以把一个已有的本地仓库与之关联，然后，把本地仓库的内容推送到GitHub仓库。
	// 现在，我们根据GitHub的提示，在本地的learngit仓库下运行命令：
	$ git remote add origin git@github.com:michaelliao/learngit.git

	// 删除远程连接
	$ git remote rm origin
	// 删除远程分支
	$ git push origin --delete master

	// 在进行git pull 时，添加一个可选项(--allow-unrelated-histories 强制合并)
	git pull origin master --allow-unrelated-histories

	//第5步：下一步，就可以把本地库的所有内容推送到远程库上：
	$ git push -u origin master


	// git push操作出现错误: github error: insufficient permission for adding an object to repository database
	git config --bool core.bare true
    // 这样就解决了权限问题。


//13，系统出现如下错误：warning: LF will be replaced by CRLF
	// 也就是说在windows中的换行符为 CRLF， 而在linux下的换行符为：LF
	// 使用git来生成一个rails工程后，文件中的换行符为LF， 当执行git add .时，系统提示：LF 将被转换成 CRLF
	// 解决方法：
	// 删除刚刚生成的.git文件
	$ rm -rf .git  
	$ git config --gobal core.autocrlf false 


//14，仓库克隆
	// 用命令git clone克隆一个本地库：
	// 方法一：
	$ git clone git@github.com:michaelliao/gitskills.git
	// 方法二：
	$ git clone https://github.com/michaelliao/gitskills.git



//15，分支管理
	// 首先，我们创建dev分支，然后切换到dev分支：
	$ git checkout -b dev
	Switched to a new branch 'dev'
	// git checkout命令加上-b参数表示创建并切换，相当于以下两条命令：
	$ git branch dev
	$ git checkout dev
	Switched to branch 'dev'

	// 然后，用git branch命令查看当前分支：
	$ git branch
	* dev
	  master
	// git branch命令会列出所有分支，当前分支前面会标一个*号。

	// 然后，我们就可以在dev分支上正常提交，比如对readme.txt做个修改，加上一行：
	// 然后提交：
	$ git add readme.txt 
	$ git commit -m "branch test"
	[dev fec145a] branch test
	 1 file changed, 1 insertion(+)

	// 现在，dev分支的工作完成，我们就可以切换回master分支：
	$ git checkout master
	Switched to branch 'master'

	// 切换回master分支后，再查看一个readme.txt文件，刚才添加的内容不见了！因为那个提交是在dev分支上，而master分支此刻的提交点并没有变：
	// 我们把dev分支的工作成果合并到master分支上：
	$ git merge dev
	Updating d17efd8..fec145a
	Fast-forward
	 readme.txt |    1 +
	 1 file changed, 1 insertion(+)


	 //git merge命令用于合并指定分支到当前分支。合并后，再查看readme.txt的内容，就可以看到，和dev分支的最新提交是完全一样的。
	// 注意到上面的Fast-forward信息，Git告诉我们，这次合并是“快进模式”，也就是直接把master指向dev的当前提交，所以合并速度非常快。
	// 当然，也不是每次合并都能Fast-forward，我们后面会讲其他方式的合并。

	// 合并完成后，就可以放心地删除dev分支了：
	$ git branch -d dev
	Deleted branch dev (was fec145a).

	// 删除后，查看branch，就只剩下master分支了：
	$ git branch
	* master

	// Git鼓励大量使用分支：
	// 查看分支：git branch
	// 创建分支：git branch <name>
	// 切换分支：git checkout <name>
	// 创建+切换分支：git checkout -b <name>
	// 合并某分支到当前分支：git merge <name>
	// 删除分支：git branch -d <name>


// 16,分支冲突
	// 这种情况下，Git无法执行“快速合并”，只能试图把各自的修改合并起来，但这种合并就可能会有冲突，我们试试看：
	$ git merge feature1
	Auto-merging readme.txt
	CONFLICT (content): Merge conflict in readme.txt
	Automatic merge failed; fix conflicts and then commit the result.

	// 果然冲突了！Git告诉我们，readme.txt文件存在冲突，必须手动解决冲突后再提交。git status也可以告诉我们冲突的文件：
	$ git status
	# On branch master
	# Your branch is ahead of 'origin/master' by 2 commits.
	#
	# Unmerged paths:
	#   (use "git add/rm <file>..." as appropriate to mark resolution)
	#
	#       both modified:      readme.txt
	#
	no changes added to commit (use "git add" and/or "git commit -a")

	// 我们可以直接查看readme.txt的内容：
	Git is a distributed version control system.
	Git is free software distributed under the GPL.
	Git has a mutable index called stage.
	Git tracks changes of files.
	#<<<<<<< HEAD
	#Creating a new branch is quick & simple.
	#=======
	#Creating a new branch is quick AND simple.
	#>>>>>>> feature1

	//Git用<<<<<<<，=======，>>>>>>>标记出不同分支的内容，我们修改如下后保存：
	// Creating a new branch is quick and simple.
	// 再提交：
	$ git add readme.txt 
	$ git commit -m "conflict fixed"
	[master 59bc1cb] conflict fixed


//17,禁止快速合并模式
	// 准备合并dev分支，请注意--no-ff参数，表示禁用Fast forward：
	$ git merge --no-ff -m "merge with no-ff" dev
	Merge made by the 'recursive' strategy.
	 readme.txt |    1 +
	 1 file changed, 1 insertion(+)

	// 因为本次合并要创建一个新的commit，所以加上-m参数，把commit描述写进去。
	// 合并后，我们用git log看看分支历史：
	$ git log --graph --pretty=oneline --abbrev-commit
	*   7825a50 merge with no-ff
	|\
	| * 6224937 add merge
	|/
	*   59bc1cb conflict fixed
	...


	// 分支策略
	// 在实际开发中，我们应该按照几个基本原则进行分支管理：
	// 首先，master分支应该是非常稳定的，也就是仅用来发布新版本，平时不能在上面干活；
	// 那在哪干活呢？干活都在dev分支上，也就是说，dev分支是不稳定的，到某个时候，比如1.0版本发布时，再把dev分支合并到master上，在master分支发布1.0版本；
	// 你和你的小伙伴们每个人都在dev分支上干活，每个人都有自己的分支，时不时地往dev分支上合并就可以了。



// 18，Git还提供了一个stash功能，可以把当前工作现场“储藏”起来，等以后恢复现场后继续工作：
	$ git stash
	Saved working directory and index state WIP on dev: 6224937 add merge
	HEAD is now at 6224937 add merge

	// 现在，用git status查看工作区，就是干净的（除非有没有被Git管理的文件），因此可以放心地创建分支来修复bug。
	// 首先确定要在哪个分支上修复bug，假定需要在master分支上修复，就从master创建临时分支：
	$ git checkout master
	Switched to branch 'master'
	Your branch is ahead of 'origin/master' by 6 commits.
	$ git checkout -b issue-101
	Switched to a new branch 'issue-101'

	// 现在修复bug，需要把“Git is free software ...”改为“Git is a free software ...”，然后提交：
	$ git add readme.txt 
	$ git commit -m "fix bug 101"
	[issue-101 cc17032] fix bug 101
	 1 file changed, 1 insertion(+), 1 deletion(-)

	// 修复完成后，切换到master分支，并完成合并，最后删除issue-101分支：
	$ git checkout master
	Switched to branch 'master'
	Your branch is ahead of 'origin/master' by 2 commits.

	$ git merge --no-ff -m "merged bug fix 101" issue-101
	Merge made by the 'recursive' strategy.
	 readme.txt |    2 +-
	 1 file changed, 1 insertion(+), 1 deletion(-)

	$ git branch -d issue-101
	Deleted branch issue-101 (was cc17032).

	//回到之前工场
	$ git checkout dev
	Switched to branch 'dev'
	$ git status
	# On branch dev
	nothing to commit (working directory clean)

	// 工作区是干净的，刚才的工作现场存到哪去了？用git stash list命令看看：
	$ git stash list
	stash@{0}: WIP on dev: 6224937 add merge

	// 工作现场还在，Git把stash内容存在某个地方了，但是需要恢复一下，有两个办法：
	// 一是用git stash apply恢复，但是恢复后，stash内容并不删除，你需要用git stash drop来删除；
	// 另一种方式是用git stash pop，恢复的同时把stash内容也删了：
	$ git stash pop
	# On branch dev
	# Changes to be committed:
	#   (use "git reset HEAD <file>..." to unstage)
	#
	#       new file:   hello.py
	#
	# Changes not staged for commit:
	#   (use "git add <file>..." to update what will be committed)
	#   (use "git checkout -- <file>..." to discard changes in working directory)
	#
	#       modified:   readme.txt
	#
	Dropped refs/stash@{0} (f624f8e5f082f2df2bed8a4e09c12fd2943bdd40)

	// 再用git stash list查看，就看不到任何stash内容了：
	$ git stash list

	// 你可以多次stash，恢复的时候，先用git stash list查看，然后恢复指定的stash，用命令：
	$ git stash apply stash@{0}



// 19，开发一个新feature，最好新建一个分支；
// 如果要丢弃一个没有被合并过的分支，可以通过git branch -D <name>强行删除。
	// 就在此时，接到上级命令，因经费不足，新功能必须取消！
	// 虽然白干了，但是这个分支还是必须就地销毁：
	$ git branch -d feature-vulcan
	error: The branch 'feature-vulcan' is not fully merged.
	If you are sure you want to delete it, run 'git branch -D feature-vulcan'.

	// 销毁失败。Git友情提醒，feature-vulcan分支还没有被合并，如果删除，将丢失掉修改，如果要强行删除，需要使用命令git branch -D feature-vulcan。

	// 现在我们强行删除：
	$ git branch -D feature-vulcan
	Deleted branch feature-vulcan (was 756d4af).
	// 终于删除成功！




//20，多人协作
	// 当你从远程仓库克隆时，实际上Git自动把本地的master分支和远程的master分支对应起来了，并且，远程仓库的默认名称是origin。

	// 要查看远程库的信息，用git remote：
	$ git remote
	origin
	// 或者，用git remote -v显示更详细的信息：
	$ git remote -v
	origin  git@github.com:michaelliao/learngit.git (fetch)
	origin  git@github.com:michaelliao/learngit.git (push)
	// 上面显示了可以抓取和推送的origin的地址。如果没有推送权限，就看不到push的地址。

	// 推送分支
	// 推送分支，就是把该分支上的所有本地提交推送到远程库。推送时，要指定本地分支，这样，Git就会把该分支推送到远程库对应的远程分支上：
	$ git push origin master

	// 如果要推送其他分支，比如dev，就改成：
	$ git push origin dev
	// 但是，并不是一定要把本地分支往远程推送，那么，哪些分支需要推送，哪些不需要呢？
	// master分支是主分支，因此要时刻与远程同步；
	// dev分支是开发分支，团队所有成员都需要在上面工作，所以也需要与远程同步；
	// bug分支只用于在本地修复bug，就没必要推到远程了，除非老板要看看你每周到底修复了几个bug；
	// feature分支是否推到远程，取决于你是否和你的小伙伴合作在上面开发。


	// 抓取分支
	// 多人协作时，大家都会往master和dev分支上推送各自的修改。
	// 现在，模拟一个你的小伙伴，可以在另一台电脑（注意要把SSH Key添加到GitHub）或者同一台电脑的另一个目录下克隆：
	$ git clone git@github.com:michaelliao/learngit.git
	Cloning into 'learngit'...
	remote: Counting objects: 46, done.
	remote: Compressing objects: 100% (26/26), done.
	remote: Total 46 (delta 16), reused 45 (delta 15)
	Receiving objects: 100% (46/46), 15.69 KiB | 6 KiB/s, done.
	Resolving deltas: 100% (16/16), done.

	// 当你的小伙伴从远程库clone时，默认情况下，你的小伙伴只能看到本地的master分支。不信可以用git branch命令看看：
	$ git branch
	* master

	// 现在，你的小伙伴要在dev分支上开发，就必须创建远程origin的dev分支到本地，于是他用这个命令创建本地dev分支：
	$ git checkout -b dev origin/dev

	// 现在，他就可以在dev上继续修改，然后，时不时地把dev分支push到远程：
	$ git commit -m "add /usr/bin/env"
	[dev 291bea8] add /usr/bin/env
	 1 file changed, 1 insertion(+)

	$ git push origin dev
	Counting objects: 5, done.
	Delta compression using up to 4 threads.
	Compressing objects: 100% (2/2), done.
	Writing objects: 100% (3/3), 349 bytes, done.
	Total 3 (delta 0), reused 0 (delta 0)
	To git@github.com:michaelliao/learngit.git
	   fc38031..291bea8  dev -> dev


	// 你的小伙伴已经向origin/dev分支推送了他的提交，而碰巧你也对同样的文件作了修改，并试图推送：
	$ git add hello.py 
	$ git commit -m "add coding: utf-8"
	[dev bd6ae48] add coding: utf-8
	 1 file changed, 1 insertion(+)

	$ git push origin dev
	To git@github.com:michaelliao/learngit.git
	 ! [rejected]        dev -> dev (non-fast-forward)
	error: failed to push some refs to 'git@github.com:michaelliao/learngit.git'
	hint: Updates were rejected because the tip of your current branch is behind
	hint: its remote counterpart. Merge the remote changes (e.g. 'git pull')
	hint: before pushing again.
	hint: See the 'Note about fast-forwards' in 'git push --help' for details.

	// 推送失败，因为你的小伙伴的最新提交和你试图推送的提交有冲突，解决办法也很简单，Git已经提示我们，先用git pull把最新的提交从origin/dev抓下来，然后，在本地合并，解决冲突，再推送：
	$ git pull
	remote: Counting objects: 5, done.
	remote: Compressing objects: 100% (2/2), done.
	remote: Total 3 (delta 0), reused 3 (delta 0)
	Unpacking objects: 100% (3/3), done.
	From github.com:michaelliao/learngit
	   fc38031..291bea8  dev        -> origin/dev
	There is no tracking information for the current branch.
	Please specify which branch you want to merge with.
	See git-pull(1) for details
    git pull <remote> <branch>
	If you wish to set tracking information for this branch you can do so with:
    git branch --set-upstream dev origin/<branch>

	// git pull也失败了，原因是没有指定本地dev分支与远程origin/dev分支的链接，根据提示，设置dev和origin/dev的链接：
	$ git branch --set-upstream dev origin/dev
	Branch dev set up to track remote branch dev from origin.

	// 再pull：
	$ git pull
	Auto-merging hello.py
	CONFLICT (content): Merge conflict in hello.py
	Automatic merge failed; fix conflicts and then commit the result.

	// 这回git pull成功，但是合并有冲突，需要手动解决，解决的方法和分支管理中的解决冲突完全一样。解决后，提交，再push：
	$ git commit -m "merge & fix hello.py"
	[dev adca45d] merge & fix hello.py

	$ git push origin dev
	Counting objects: 10, done.
	Delta compression using up to 4 threads.
	Compressing objects: 100% (5/5), done.
	Writing objects: 100% (6/6), 747 bytes, done.
	Total 6 (delta 0), reused 0 (delta 0)
	To git@github.com:michaelliao/learngit.git
	   291bea8..adca45d  dev -> dev




	// 因此，多人协作的工作模式通常是这样：
	// 首先，可以试图用git push origin branch-name推送自己的修改；
	// 如果推送失败，则因为远程分支比你的本地更新，需要先用git pull试图合并；
	// 如果合并有冲突，则解决冲突，并在本地提交；
	// 没有冲突或者解决掉冲突后，再用git push origin branch-name推送就能成功！
	// 如果git pull提示“no tracking information”，则说明本地分支和远程分支的链接关系没有创建，用命令git branch --set-upstream branch-name origin/branch-name。
	// 这就是多人协作的工作模式，一旦熟悉了，就非常简单。

	// 小结
	// 查看远程库信息，使用git remote -v；
	// 本地新建的分支如果不推送到远程，对其他人就是不可见的；
	// 从本地推送分支，使用git push origin branch-name，如果推送失败，先用git pull抓取远程的新提交；
	// 在本地创建和远程分支对应的分支，使用git checkout -b branch-name origin/branch-name，本地和远程分支的名称最好一致；
	// 建立本地分支和远程分支的关联，使用git branch --set-upstream branch-name origin/branch-name；
	// 从远程抓取分支，使用git pull，如果有冲突，要先处理冲突。







//21，签名
	// 创建标签

	// 在Git中打标签非常简单，首先，切换到需要打标签的分支上：
	$ git branch
	* dev
	  master
	$ git checkout master
	Switched to branch 'master'

	// 然后，敲命令git tag <name>就可以打一个新标签：
	$ git tag v1.0

	// 可以用命令git tag查看所有标签：
	$ git tag
	v1.0

	// 默认标签是打在最新提交的commit上的。有时候，如果忘了打标签，比如，现在已经是周五了，但应该在周一打的标签没有打，怎么办？
	// 方法是找到历史提交的commit id，然后打上就可以了：
	$ git log --pretty=oneline --abbrev-commit
	6a5819e merged bug fix 101
	cc17032 fix bug 101
	7825a50 merge with no-ff
	6224937 add merge
	59bc1cb conflict fixed
	400b400 & simple
	75a857c AND simple
	fec145a branch test
	d17efd8 remove test.txt
	...

	// 比方说要对add merge这次提交打标签，它对应的commit id是6224937，敲入命令：
	$ git tag v0.9 6224937
	// 再用命令git tag查看标签：
	$ git tag
	v0.9
	v1.0

	// 注意，标签不是按时间顺序列出，而是按字母排序的。可以用git show <tagname>查看标签信息：
	$ git show v0.9
	commit 622493706ab447b6bb37e4e2a2f276a20fed2ab4
	Author: Michael Liao <askxuefeng@gmail.com>
	Date:   Thu Aug 22 11:22:08 2013 +0800

	    add merge
	...

	// 可以看到，v0.9确实打在add merge这次提交上。
	// 还可以创建带有说明的标签，用-a指定标签名，-m指定说明文字：
	$ git tag -a v0.1 -m "version 0.1 released" 3628164

	// 用命令git show <tagname>可以看到说明文字：
	$ git show v0.1
	tag v0.1
	Tagger: Michael Liao <askxuefeng@gmail.com>
	Date:   Mon Aug 26 07:28:11 2013 +0800

	version 0.1 released

	commit 3628164fb26d48395383f8f31179f24e0882e1e0
	Author: Michael Liao <askxuefeng@gmail.com>
	Date:   Tue Aug 20 15:11:49 2013 +0800

	    append GPL


	// 还可以通过-s用私钥签名一个标签：
	$ git tag -s v0.2 -m "signed version 0.2 released" fec145a

	// 签名采用PGP签名，因此，必须首先安装gpg（GnuPG），如果没有找到gpg，或者没有gpg密钥对，就会报错：
	gpg: signing failed: secret key not available
	error: gpg failed to sign the data
	error: unable to sign the tag
	// 如果报错，请参考GnuPG帮助文档配置Key。

	// 用命令git show <tagname>可以看到PGP签名信息：
	$ git show v0.2
	tag v0.2
	Tagger: Michael Liao <askxuefeng@gmail.com>
	Date:   Mon Aug 26 07:28:33 2013 +0800

	signed version 0.2 released
	-----BEGIN PGP SIGNATURE-----
	Version: GnuPG v1.4.12 (Darwin)

	iQEcBAABAgAGBQJSGpMhAAoJEPUxHyDAhBpT4QQIAKeHfR3bo...
	-----END PGP SIGNATURE-----

	commit fec145accd63cdc9ed95a2f557ea0658a2a6537f
	Author: Michael Liao <askxuefeng@gmail.com>
	Date:   Thu Aug 22 10:37:30 2013 +0800

	    branch test

	// 用PGP签名的标签是不可伪造的，因为可以验证PGP签名。验证签名的方法比较复杂


	// 命令git tag <name>用于新建一个标签，默认为HEAD，也可以指定一个commit id；
	// git tag -a <tagname> -m "blablabla..."可以指定标签信息；
	// git tag -s <tagname> -m "blablabla..."可以用PGP签名标签；
	// 命令git tag可以查看所有标签。



// 21，删除标签
	// 如果标签打错了，也可以删除：
	$ git tag -d v0.1
	Deleted tag 'v0.1' (was e078af9)

	// 因为创建的标签都只存储在本地，不会自动推送到远程。所以，打错的标签可以在本地安全删除。
	// 如果要推送某个标签到远程，使用命令git push origin <tagname>：
	$ git push origin v1.0
	Total 0 (delta 0), reused 0 (delta 0)
	To git@github.com:michaelliao/learngit.git
	 * [new tag]         v1.0 -> v1.0

	// 或者，一次性推送全部尚未推送到远程的本地标签：
	$ git push origin --tags
	Counting objects: 1, done.
	Writing objects: 100% (1/1), 554 bytes, done.
	Total 1 (delta 0), reused 0 (delta 0)
	To git@github.com:michaelliao/learngit.git
	 * [new tag]         v0.2 -> v0.2
	 * [new tag]         v0.9 -> v0.9

	// 如果标签已经推送到远程，要删除远程标签就麻烦一点，先从本地删除：
	$ git tag -d v0.9
	Deleted tag 'v0.9' (was 6224937)

	// 然后，从远程删除。删除命令也是push，但是格式如下：
	$ git push origin :refs/tags/v0.9
	To git@github.com:michaelliao/learngit.git
	 - [deleted]         v0.9
	// 要看看是否真的从远程库删除了标签，可以登陆GitHub查看。




22，忽略特殊文件
	// 在Git工作区的根目录下创建一个特殊的.gitignore文件，然后把要忽略的文件名填进去，Git就会自动忽略这些文件。
	// 不需要从头写.gitignore文件，GitHub已经为我们准备了各种配置文件，只需要组合一下就可以使用了。所有配置文件可以直接在线浏览：https://github.com/github/gitignore
	// 忽略文件的原则是：
	// 忽略操作系统自动生成的文件，比如缩略图等；
	// 忽略编译生成的中间文件、可执行文件等，也就是如果一个文件是通过另一个文件自动生成的，那自动生成的文件就没必要放进版本库，比如Java编译产生的.class文件；
	// 忽略你自己的带有敏感信息的配置文件，比如存放口令的配置文件。

	// 举个例子：
	// 假设你在Windows下进行Python开发，Windows会自动在有图片的目录下生成隐藏的缩略图文件，如果有自定义目录，目录下就会有Desktop.ini文件，因此你需要忽略Windows自动生成的垃圾文件：

	// # Windows:
	// Thumbs.db
	// ehthumbs.db
	// Desktop.ini
	// 然后，继续忽略Python编译产生的.pyc、.pyo、dist等文件或目录：

	// # Python:
	// *.py[cod]
	// *.so
	// *.egg
	// *.egg-info
	// dist
	// build
	// 加上你自己定义的文件，最终得到一个完整的.gitignore文件，内容如下：

	// # Windows:
	// Thumbs.db
	// ehthumbs.db
	// Desktop.ini

	// # Python:
	// *.py[cod]
	// *.so
	// *.egg
	// *.egg-info
	// dist
	// build

	// # My configurations:
	// db.ini
	// deploy_key_rsa
	// 最后一步就是把.gitignore也提交到Git，就完成了！当然检验.gitignore的标准是git status命令是不是说working directory clean。

	// 有些时候，你想添加一个文件到Git，但发现添加不了，原因是这个文件被.gitignore忽略了：

	$ git add App.class
	The following paths are ignored by one of your .gitignore files:
	App.class
	Use -f if you really want to add them.

	// 如果你确实想添加该文件，可以用-f强制添加到Git：
	$ git add -f App.class
	// 或者你发现，可能是.gitignore写得有问题，需要找出来到底哪个规则写错了，可以用git check-ignore命令检查：

	$ git check-ignore -v App.class
	.gitignore:3:*.class    App.class
	// Git会告诉我们，.gitignore的第3行规则忽略了该文件，于是我们就可以知道应该修订哪个规则。





// 23，配置别名
	// 我们只需要敲一行命令，告诉Git，以后st就表示status：
	$ git config --global alias.st status
	// 好了，现在敲git st看看效果。

	// 当然还有别的命令可以简写，很多人都用co表示checkout，ci表示commit，br表示branch：

	$ git config --global alias.co checkout
	$ git config --global alias.ci commit
	$ git config --global alias.br branch
	// 以后提交就可以简写成：
	$ git ci -m "bala bala bala..."
	// --global参数是全局参数，也就是这些命令在这台电脑的所有Git仓库下都有用。

	// 在撤销修改一节中，我们知道，命令git reset HEAD file可以把暂存区的修改撤销掉（unstage），重新放回工作区。既然是一个unstage操作，就可以配置一个unstage别名：
	$ git config --global alias.unstage 'reset HEAD'

	// 当你敲入命令：
	$ git unstage test.py
	// 实际上Git执行的是：
	$ git reset HEAD test.py

	// 配置一个git last，让其显示最后一次提交信息：
	$ git config --global alias.last 'log -1'

	// 这样，用git last就能显示最近一次的提交：
	$ git last
	commit adca45d317e6d8a4b23f9811c3d7b7f0f180bfe2
	Merge: bd6ae48 291bea8
	Author: Michael Liao <askxuefeng@gmail.com>
	Date:   Thu Aug 22 22:49:22 2013 +0800

	    merge & fix hello.py


	// 甚至还有人丧心病狂地把lg配置成了：
	git config --global alias.lg "log --color --graph --pretty=format:'%Cred%h%Creset -%C(yellow)%d%Creset %s %Cgreen(%cr) %C(bold blue)<%an>%Creset' --abbrev-commit"



	// 配置文件

	// 配置Git的时候，加上--global是针对当前用户起作用的，如果不加，那只针对当前的仓库起作用。

	// 配置文件放哪了？每个仓库的Git配置文件都放在.git/config文件中：

	$ cat .git/config 
	[core]
	    repositoryformatversion = 0
	    filemode = true
	    bare = false
	    logallrefupdates = true
	    ignorecase = true
	    precomposeunicode = true
	[remote "origin"]
	    url = git@github.com:michaelliao/learngit.git
	[branch "master"]
	    remote = origin
	    merge = refs/heads/master
	[alias]
	    last = log -1

	// 别名就在[alias]后面，要删除别名，直接把对应的行删掉即可。


	// 而当前用户的Git配置文件放在用户主目录下的一个隐藏文件.gitconfig中：
	[alias]
	    co = checkout
	    ci = commit
	    br = branch
	    st = status
	[user]
	    name = Your Name
	    email = your@email.com





// 25，搭建git服务器
	// 第一步，安装git：
	$ sudo apt-get install git

	// 第二步，创建一个git用户，用来运行git服务：
	$ sudo adduser git

	// 第三步，创建证书登录：
	// 收集所有需要登录的用户的公钥，就是他们自己的id_rsa.pub文件，把所有公钥导入到/home/git/.ssh/authorized_keys文件里，一行一个。

	// 第四步，初始化Git仓库：
	// 先选定一个目录作为Git仓库，假定是/srv/sample.git，在/srv目录下输入命令：
	$ sudo git init --bare sample.git
	// Git就会创建一个裸仓库，裸仓库没有工作区，因为服务器上的Git仓库纯粹是为了共享，所以不让用户直接登录到服务器上去改工作区，并且服务器上的Git仓库通常都以.git结尾。然后，把owner改为git：
	$ sudo chown -R git:git sample.git
	
	// 第五步，禁用shell登录：
	// 出于安全考虑，第二步创建的git用户不允许登录shell，这可以通过编辑/etc/passwd文件完成。找到类似下面的一行：
	git:x:1001:1001:,,,:/home/git:/bin/bash
	// 改为：
	git:x:1001:1001:,,,:/home/git:/usr/bin/git-shell
	// 这样，git用户可以正常通过ssh使用git，但无法登录shell，因为我们为git用户指定的git-shell每次一登录就自动退出。

	// 第六步，克隆远程仓库：
	// 现在，可以通过git clone命令克隆远程仓库了，在各自的电脑上运行：
	$ git clone git@server:/srv/sample.git
	Cloning into 'sample'...
	warning: You appear to have cloned an empty repository.
	// 剩下的推送就简单了。