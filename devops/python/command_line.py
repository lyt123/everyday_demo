import subprocess

cmd = "echo hehe"

# 1. execute and get output
# execute
child = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE)
# wait the process to terminate and get output, notice popen should use pipe
output = child.communicate()

# 2. execute
# execute utill finish
subprocess.call(cmd, shell=True)

# 3. execute, raise error if return code is not 0
# execute utill finish
subprocess.check_call(cmd, shell=True)

# 3. execute and get output, raise error if return code is not 0
# execute utill finish
subprocess.check_output(cmd, shell=True)

